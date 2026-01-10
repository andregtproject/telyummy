<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Selamat Datang') }}, {{ Auth::user()->name }}! 👋
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Search & Filter Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        {{-- Search --}}
                        <div class="flex-1">
                            <div class="relative">
                                <input type="text"
                                       id="search"
                                       placeholder="Cari kantin atau menu..."
                                       class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div class="flex gap-2 flex-wrap">
                            <button class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white">
                                Semua
                            </button>
                            @foreach($categories as $category)
                                <button class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-600 transition">
                                    {{ $category }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active Orders Banner --}}
            @php
                $activeOrders = Auth::user()->orders()
                    ->whereIn('status', ['menunggu', 'diproses'])
                    ->count();
            @endphp
            @if($activeOrders > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-blue-800">Kamu punya {{ $activeOrders }} pesanan aktif</p>
                                <p class="text-sm text-blue-600">Lihat status pesananmu sekarang</p>
                            </div>
                        </div>
                        <a href="{{ route('orders.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition">
                            Lihat Pesanan
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Canteen Section Title --}}
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Kantin Tersedia</h3>
                <span class="text-sm text-gray-500">{{ $canteens->count() }} kantin buka</span>
            </div>

            {{-- Canteen Grid --}}
            @if($canteens->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($canteens as $canteen)
                        <a href="{{ route('canteen.menu', $canteen->slug) }}"
                           class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow group">
                            {{-- Canteen Image --}}
                            <div class="relative aspect-video">
                                @if($canteen->image)
                                    @php
                                        $imageUrl = str_starts_with($canteen->image, 'http')
                                            ? $canteen->image
                                            : Storage::url($canteen->image);
                                    @endphp
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $canteen->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Status Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                        Buka
                                    </span>
                                </div>

                                {{-- Category Badge --}}
                                @if($canteen->category)
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/90 text-gray-700">
                                            {{ $canteen->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Canteen Info --}}
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-900 group-hover:text-red-600 transition">
                                    {{ $canteen->name }}
                                </h4>

                                @if($canteen->description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                        {{ $canteen->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                    {{-- Rating --}}
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ number_format($canteen->rating ?? 0, 1) }}
                                        </span>
                                    </div>

                                    {{-- Menu Count --}}
                                    @php
                                        $menuCount = $canteen->menuItems()->where('is_available', true)->count();
                                    @endphp
                                    <span class="text-sm text-gray-500">
                                        {{ $menuCount }} menu
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kantin yang buka</h3>
                        <p class="mt-1 text-sm text-gray-500">Semua kantin sedang tutup. Coba lagi nanti!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
