@props(['order'])

@php
use Illuminate\Support\Facades\Storage;
@endphp

<a href="{{ route('orders.show', $order) }}"
   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
    <div class="p-4">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                {{-- Canteen Avatar --}}
                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($order->canteen->image)
                        <img src="{{ Storage::url($order->canteen->image) }}"
                             alt="{{ $order->canteen->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-icons.image-placeholder class="w-5 h-5 text-gray-400" />
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">{{ $order->canteen->name }}</h4>
                    <p class="text-xs text-gray-500">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            {{-- Status Badge --}}
            <x-order-status-badge :status="$order->status" />
        </div>

        {{-- Order Items Preview --}}
        <div class="flex items-center gap-3 mb-3">
            {{-- Item Thumbnails --}}
            <div class="flex -space-x-2">
                @foreach($order->orderItems->take(3) as $orderItem)
                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 border-2 border-white">
                        @if($orderItem->menuItem && $orderItem->menuItem->image)
                            <x-order-thumbnail 
                                :src="$orderItem->menuItem->image" 
                                :alt="$orderItem->menuItem->name"
                                size="sm"
                                class="w-full h-full"
                            />
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <x-icons.image-placeholder class="w-4 h-4 text-gray-400" />
                            </div>
                        @endif
                    </div>
                @endforeach
                @if($order->orderItems->count() > 3)
                    <div class="w-10 h-10 rounded-lg bg-gray-100 border-2 border-white flex items-center justify-center">
                        <span class="text-xs font-medium text-gray-600">+{{ $order->orderItems->count() - 3 }}</span>
                    </div>
                @endif
            </div>

            {{-- Items Summary --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-600 truncate">
                    @php
                        $itemNames = $order->orderItems->take(2)->map(function($item) {
                            return $item->menuItem ? $item->menuItem->name : 'Item dihapus';
                        })->join(', ');
                        if ($order->orderItems->count() > 2) {
                            $itemNames .= ', +' . ($order->orderItems->count() - 2) . ' lainnya';
                        }
                    @endphp
                    {{ $itemNames }}
                </p>
                <p class="text-xs text-gray-500">
                    {{ $order->orderItems->sum('quantity') }} item
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <span class="text-gray-600 text-sm">Total Pembayaran</span>
            <span class="font-bold text-red-600">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</a>
