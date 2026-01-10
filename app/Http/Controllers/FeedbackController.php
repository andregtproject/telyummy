<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Pembeli: Daftar feedback yang pernah dikirim
     */
    public function index()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())
            ->with(['canteen', 'order'])
            ->latest()
            ->paginate(10);

        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Pembeli: Form untuk membuat feedback baru
     */
    public function create(Request $request)
    {
        // Get canteens for dropdown
        $canteens = Canteen::where('is_open', true)->get();
        
        // Pre-select canteen if provided
        $selectedCanteen = null;
        $selectedOrder = null;
        
        if ($request->has('canteen_id')) {
            $selectedCanteen = Canteen::find($request->canteen_id);
        }
        
        if ($request->has('order_id')) {
            $selectedOrder = Order::where('id', $request->order_id)
                ->where('user_id', Auth::id())
                ->first();
            if ($selectedOrder) {
                $selectedCanteen = $selectedOrder->canteen;
            }
        }

        return view('feedbacks.create', compact('canteens', 'selectedCanteen', 'selectedOrder'));
    }

    /**
     * Pembeli: Simpan feedback baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'canteen_id' => 'required|exists:canteens,id',
            'order_id' => 'nullable|exists:orders,id',
            'content' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'canteen_id' => $validated['canteen_id'],
            'order_id' => $validated['order_id'] ?? null,
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'status' => Feedback::STATUS_MENUNGGU,
        ]);

        return redirect()->route('feedbacks.show', $feedback)
            ->with('success', 'Feedback berhasil dikirim! Terima kasih atas masukan Anda.');
    }

    /**
     * Pembeli: Detail feedback + tanggapan
     */
    public function show(Feedback $feedback)
    {
        // Pastikan hanya pemilik feedback yang bisa lihat
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $feedback->load(['canteen', 'order']);

        return view('feedbacks.show', compact('feedback'));
    }

    // ==========================================
    // PENJUAL METHODS
    // ==========================================

    /**
     * Penjual: Daftar feedback yang masuk ke kantin
     */
    public function sellerIndex(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->canteen) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum memiliki kantin.');
        }

        $query = Feedback::where('canteen_id', $user->canteen->id)
            ->with(['user', 'order']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $feedbacks = $query->latest()->paginate(10);
        
        // Count per status untuk tabs
        $counts = [
            'all' => Feedback::where('canteen_id', $user->canteen->id)->count(),
            'menunggu' => Feedback::where('canteen_id', $user->canteen->id)->menunggu()->count(),
            'dibaca' => Feedback::where('canteen_id', $user->canteen->id)->dibaca()->count(),
            'ditanggapi' => Feedback::where('canteen_id', $user->canteen->id)->ditanggapi()->count(),
        ];

        return view('feedbacks.seller-index', compact('feedbacks', 'counts'));
    }

    /**
     * Penjual: Detail feedback
     */
    public function sellerShow(Feedback $feedback)
    {
        $user = Auth::user();
        
        // Pastikan feedback untuk kantin penjual ini
        if (!$user->canteen || $feedback->canteen_id !== $user->canteen->id) {
            abort(403);
        }

        // Mark as read if still menunggu
        $feedback->markAsRead();
        
        $feedback->load(['user', 'order']);

        return view('feedbacks.seller-show', compact('feedback'));
    }

    /**
     * Penjual: Kirim tanggapan ke feedback
     */
    public function respond(Request $request, Feedback $feedback)
    {
        $user = Auth::user();
        
        // Pastikan feedback untuk kantin penjual ini
        if (!$user->canteen || $feedback->canteen_id !== $user->canteen->id) {
            abort(403);
        }

        $validated = $request->validate([
            'response' => 'required|string|min:10|max:1000',
        ]);

        $feedback->addResponse($validated['response']);

        return redirect()->route('seller.feedbacks.show', $feedback)
            ->with('success', 'Tanggapan berhasil dikirim!');
    }

    /**
     * Penjual: Update status feedback
     */
    public function updateStatus(Request $request, Feedback $feedback)
    {
        $user = Auth::user();
        
        // Pastikan feedback untuk kantin penjual ini
        if (!$user->canteen || $feedback->canteen_id !== $user->canteen->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:menunggu,dibaca,ditanggapi',
        ]);

        $feedback->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', 'Status feedback berhasil diperbarui!');
    }
}
