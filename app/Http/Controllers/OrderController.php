<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    // ==========================================
    // PEMBELI (BUYER) METHODS
    // ==========================================

    /**
     * Display pembeli's order history.
     */
    public function index(Request $request): View
    {
        $query = Auth::user()
            ->orders()
            ->with(['canteen', 'orderItems.menuItem']);

        // Filter by status
        $status = $request->get('status');
        if ($status === 'active') {
            $query->whereIn('status', [Order::STATUS_MENUNGGU, Order::STATUS_DIPROSES]);
        } elseif ($status === 'selesai') {
            $query->where('status', Order::STATUS_SELESAI);
        } elseif ($status === 'batal') {
            $query->where('status', Order::STATUS_BATAL);
        }

        $orders = $query->orderByDesc('created_at')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display a canteen's menu for ordering.
     */
    public function showMenu(Canteen $canteen): View
    {
        if (!$canteen->is_open) {
            abort(404, 'Kantin sedang tutup.');
        }

        $menuItems = $canteen->availableMenuItems()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $categories = $menuItems->pluck('category')->unique()->filter()->values();

        return view('orders.menu', compact('canteen', 'menuItems', 'categories'));
    }

    /**
     * Show checkout page.
     */
    public function checkout(Canteen $canteen): View
    {
        if (!$canteen->is_open) {
            abort(404, 'Kantin sedang tutup.');
        }

        $menuItems = $canteen->availableMenuItems()->get();

        return view('orders.checkout', compact('canteen', 'menuItems'));
    }

    /**
     * Store a newly created order (checkout process).
     * Supports both JSON (Alpine.js) and form submissions.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'canteen_id' => ['required', 'exists:canteens,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_item_id' => ['required', 'exists:menu_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.notes' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'], // Order-level notes
        ]);

        $canteen = Canteen::findOrFail($validated['canteen_id']);

        if (!$canteen->is_open) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Maaf, kantin sedang tutup.'], 422);
            }
            return redirect()
                ->back()
                ->with('error', 'Maaf, kantin sedang tutup.');
        }

        // Calculate total and verify items belong to canteen
        $totalPrice = 0;
        $orderItemsData = [];

        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::where('id', $item['menu_item_id'])
                ->where('canteen_id', $canteen->id)
                ->where('is_available', true)
                ->first();

            if (!$menuItem) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Beberapa item tidak tersedia. Silakan coba lagi.'], 422);
                }
                return redirect()
                    ->back()
                    ->with('error', 'Beberapa item tidak tersedia. Silakan coba lagi.');
            }

            $subtotal = $menuItem->price * $item['quantity'];
            $totalPrice += $subtotal;

            $orderItemsData[] = [
                'menu_item_id' => $menuItem->id,
                'quantity' => $item['quantity'],
                'price' => $menuItem->price, // Price snapshot
                'notes' => $item['notes'] ?? null,
            ];
        }

        // Create order with transaction
        $order = DB::transaction(function () use ($validated, $canteen, $totalPrice, $orderItemsData) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'canteen_id' => $canteen->id,
                'total_price' => $totalPrice,
                'status' => Order::STATUS_MENUNGGU,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }

            return $order;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'redirect' => route('orders.show', $order),
            ]);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari penjual.');
    }

    /**
     * Display the specified order (for pembeli).
     */
    public function show(Order $order): View
    {
        // Ensure pembeli can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['canteen', 'orderItems.menuItem']);

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order (for pembeli, only if status is menunggu).
     */
    public function cancel(Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if (!$order->canBeCancelled()) {
            return redirect()
                ->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => Order::STATUS_BATAL]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // ==========================================
    // PENJUAL (SELLER) METHODS
    // ==========================================

    /**
     * Display incoming orders for penjual's canteen.
     */
    public function incoming(): View
    {
        $canteen = Auth::user()->canteen;

        if (!$canteen) {
            abort(404, 'Anda belum memiliki kantin.');
        }

        $orders = $canteen->orders()
            ->with(['user', 'orderItems.menuItem'])
            ->whereIn('status', [Order::STATUS_MENUNGGU, Order::STATUS_DIPROSES])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('orders.incoming', compact('canteen', 'orders'));
    }

    /**
     * Display order history for penjual's canteen.
     */
    public function history(): View
    {
        $canteen = Auth::user()->canteen;

        if (!$canteen) {
            abort(404, 'Anda belum memiliki kantin.');
        }

        $orders = $canteen->orders()
            ->with(['user', 'orderItems.menuItem'])
            ->whereIn('status', [Order::STATUS_SELESAI, Order::STATUS_BATAL])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('orders.history', compact('canteen', 'orders'));
    }

    /**
     * Display a specific order (for penjual).
     */
    public function showForSeller(Order $order): View
    {
        $canteen = Auth::user()->canteen;

        if (!$canteen || $order->canteen_id !== $canteen->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['user', 'orderItems.menuItem']);

        return view('orders.show-seller', compact('order', 'canteen'));
    }

    /**
     * Update order status (for penjual).
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $canteen = Auth::user()->canteen;

        if (!$canteen || $order->canteen_id !== $canteen->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::getStatuses())],
        ]);

        $newStatus = $validated['status'];

        // Validate status transitions
        $validTransition = match ($order->status) {
            Order::STATUS_MENUNGGU => in_array($newStatus, [Order::STATUS_DIPROSES, Order::STATUS_BATAL]),
            Order::STATUS_DIPROSES => in_array($newStatus, [Order::STATUS_SELESAI, Order::STATUS_BATAL]),
            default => false,
        };

        if (!$validTransition) {
            return redirect()
                ->back()
                ->with('error', 'Perubahan status tidak valid.');
        }

        $order->update(['status' => $newStatus]);

        $statusLabel = match ($newStatus) {
            Order::STATUS_DIPROSES => 'diproses',
            Order::STATUS_SELESAI => 'selesai',
            Order::STATUS_BATAL => 'dibatalkan',
            default => $newStatus,
        };

        return redirect()
            ->back()
            ->with('success', "Pesanan #{$order->id} telah {$statusLabel}.");
    }

    // ==========================================
    // API METHODS (for Alpine.js cart)
    // ==========================================

    /**
     * Get menu items data for cart (JSON response).
     */
    public function getMenuItems(Canteen $canteen): JsonResponse
    {
        $menuItems = $canteen->availableMenuItems()
            ->select(['id', 'name', 'price', 'image', 'category'])
            ->get();

        return response()->json($menuItems);
    }
}
