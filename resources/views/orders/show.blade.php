<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <x-icons.arrow-left class="w-6 h-6" />
            </a>
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                    {{ __('Detail Pesanan') }}
                </h2>
                <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Status Banner --}}
            @include('orders.partials.status-banner', ['status' => $order->status])

            {{-- Canteen Info --}}
            @include('orders.partials.canteen-info', ['canteen' => $order->canteen])

            {{-- Order Items --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Detail Pesanan</h3>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach($order->orderItems as $item)
                        @include('orders.partials.order-item', ['item' => $item])
                    @endforeach
                </div>

                {{-- Order Notes --}}
                @if($order->notes)
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Catatan:</span> {{ $order->notes }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Payment Summary --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Ringkasan Pembayaran</h3>
                </div>

                <div class="p-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal ({{ $order->orderItems->sum('quantity') }} item)</span>
                        <span class="font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-900">Total Pembayaran</span>
                        <span class="text-xl font-bold text-red-600">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">
                        Pembayaran dilakukan langsung ke penjual saat mengambil pesanan.
                    </p>
                </div>
            </div>

            {{-- Order Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Informasi Pesanan</h3>
                </div>

                <div class="p-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Nomor Pesanan</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Waktu Pemesanan</span>
                        <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($order->status === 'selesai' && $order->updated_at != $order->created_at)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Waktu Selesai</span>
                            <span class="font-medium">{{ $order->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Cancel Button (only for menunggu status) --}}
            @if($order->status === 'menunggu')
                <div class="flex justify-end" x-data="{ showConfirm: false }">
                    <button @click="showConfirm = true"
                            class="inline-flex items-center px-4 py-2 bg-white border border-red-300 text-red-600 rounded-lg font-medium hover:bg-red-50 transition">
                        <x-icons.x-mark class="w-5 h-5 mr-2" />
                        Batalkan Pesanan
                    </button>

                    {{-- Confirm Modal --}}
                    <x-order-confirm-modal
                        x-show="showConfirm"
                        title="Batalkan Pesanan?"
                        description="Apakah kamu yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan."
                        confirmLabel="Ya, Batalkan"
                        cancelLabel="Tidak, Kembali"
                        :formAction="route('orders.cancel', $order)"
                        variant="danger"
                        @close="showConfirm = false"
                    />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
