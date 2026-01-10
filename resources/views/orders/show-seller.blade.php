<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition">
                <x-icons.arrow-left class="w-5 h-5 text-gray-600" />
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Detail Pesanan') }} #{{ $order->id }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Order Items --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                        @if($item->menuItem && $item->menuItem->image)
                                            @php
                                                $imageUrl = str_starts_with($item->menuItem->image, 'http')
                                                    ? $item->menuItem->image
                                                    : Storage::url($item->menuItem->image);
                                            @endphp
                                            <img src="{{ $imageUrl }}"
                                                 alt="{{ $item->menuItem->name ?? 'Menu' }}"
                                                 class="w-16 h-16 rounded-lg object-cover">
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <x-icons.image-placeholder class="w-8 h-8 text-gray-400" />
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $item->menuItem->name ?? 'Menu tidak tersedia' }}</h4>
                                            <p class="text-sm text-gray-500">{{ $item->formatted_price }} × {{ $item->quantity }}</p>
                                            @if($item->notes)
                                                <p class="text-sm text-gray-600 mt-1 italic bg-yellow-50 px-2 py-1 rounded">
                                                    📝 {{ $item->notes }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span class="font-bold text-gray-900">{{ $item->formatted_subtotal }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Order Notes --}}
                            @if($order->notes)
                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <h4 class="font-medium text-yellow-800 mb-1">Catatan Pesanan:</h4>
                                    <p class="text-yellow-700">{{ $order->notes }}</p>
                                </div>
                            @endif

                            {{-- Total --}}
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-red-600">{{ $order->formatted_total_price }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                        @if($order->user->avatar)
                                            <img src="{{ Storage::url($order->user->avatar) }}"
                                                 alt="{{ $order->user->name }}"
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Status Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h3>

                            {{-- Current Status --}}
                            <div class="mb-4">
                                @include('orders.partials.status-banner', ['status' => $order->status])
                            </div>

                            {{-- Action Buttons --}}
                            @if(in_array($order->status, ['menunggu', 'diproses']))
                                <div class="space-y-2">
                                    @if($order->status === 'menunggu')
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 transition">
                                                <x-icons.check class="w-4 h-4 mr-2" />
                                                Terima & Proses
                                            </button>
                                        </form>
                                    @elseif($order->status === 'diproses')
                                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 transition">
                                                <x-icons.check class="w-4 h-4 mr-2" />
                                                Tandai Selesai
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('seller.orders.update-status', $order) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="batal">
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-100 border border-transparent rounded-lg font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 transition">
                                            <x-icons.x-mark class="w-4 h-4 mr-2" />
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Order Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Info Pesanan</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm text-gray-500">ID Pesanan</dt>
                                    <dd class="font-medium text-gray-900">#{{ $order->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Tanggal Pesan</dt>
                                    <dd class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Terakhir Update</dt>
                                    <dd class="font-medium text-gray-900">{{ $order->updated_at->diffForHumans() }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500">Jumlah Item</dt>
                                    <dd class="font-medium text-gray-900">{{ $order->orderItems->sum('quantity') }} item</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
