<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Pesanan Masuk') }}
            </h2>
            <a href="{{ route('seller.orders.history') }}"
               class="text-sm text-gray-500 hover:text-red-600 transition">
                Lihat Riwayat →
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Stats Summary --}}
            @php
                $menungguCount = $orders->where('status', 'menunggu')->count();
                $diprosesCount = $orders->where('status', 'diproses')->count();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                            <x-icons.clock class="w-5 h-5 text-yellow-600" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-yellow-700">{{ $menungguCount }}</p>
                            <p class="text-sm text-yellow-600">Menunggu Konfirmasi</p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-700">{{ $diprosesCount }}</p>
                            <p class="text-sm text-blue-600">Sedang Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <x-icons.cart class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-700">{{ $orders->total() }}</p>
                            <p class="text-sm text-gray-600">Total Pesanan Aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orders List --}}
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                {{-- Order Header --}}
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-4">
                                        <div>
                                            <span class="text-sm text-gray-500">Order #{{ $order->id }}</span>
                                            <h3 class="font-semibold text-gray-900">{{ $order->user->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <x-order-status-badge :status="$order->status" />
                                        <span class="text-lg font-bold text-red-600">{{ $order->formatted_total_price }}</span>
                                    </div>
                                </div>

                                {{-- Order Items --}}
                                <div class="border-t border-b border-gray-100 py-4 mb-4">
                                    <div class="space-y-2">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="flex items-center gap-3">
                                                    @if($item->menuItem && $item->menuItem->image)
                                                        @php
                                                            $imageUrl = str_starts_with($item->menuItem->image, 'http')
                                                                ? $item->menuItem->image
                                                                : Storage::url($item->menuItem->image);
                                                        @endphp
                                                        <img src="{{ $imageUrl }}"
                                                             alt="{{ $item->menuItem->name ?? 'Menu' }}"
                                                             class="w-10 h-10 rounded-lg object-cover">
                                                    @else
                                                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                            <x-icons.image-placeholder class="w-5 h-5 text-gray-400" />
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-medium text-gray-900">{{ $item->menuItem->name ?? 'Menu tidak tersedia' }}</p>
                                                        @if($item->notes)
                                                            <p class="text-xs text-gray-500 italic">{{ $item->notes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-gray-600">{{ $item->quantity }}x</span>
                                                    <span class="text-gray-900 ml-2">{{ $item->formatted_subtotal }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Order Notes --}}
                                @if($order->notes)
                                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Catatan:</span> {{ $order->notes }}
                                        </p>
                                    </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap gap-2">
                                    @if($order->status === 'menunggu')
                                        {{-- Accept Order --}}
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 transition">
                                                <x-icons.check class="w-4 h-4 mr-2" />
                                                Terima & Proses
                                            </button>
                                        </form>

                                        {{-- Reject Order --}}
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menolak pesanan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="batal">
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-lg font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 transition">
                                                <x-icons.x-mark class="w-4 h-4 mr-2" />
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($order->status === 'diproses')
                                        {{-- Complete Order --}}
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 transition">
                                                <x-icons.check class="w-4 h-4 mr-2" />
                                                Selesai
                                            </button>
                                        </form>

                                        {{-- Cancel Order --}}
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="batal">
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-lg font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 transition">
                                                <x-icons.x-mark class="w-4 h-4 mr-2" />
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- View Detail --}}
                                    <a href="{{ route('seller.orders.show', $order) }}"
                                       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 transition">
                                        <x-icons.eye class="w-4 h-4 mr-2" />
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <x-order-empty-state
                        icon="cart"
                        title="Tidak ada pesanan aktif"
                        description="Pesanan baru akan muncul di sini."
                    />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
