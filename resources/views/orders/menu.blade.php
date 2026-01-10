<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                <x-icons.arrow-left class="w-6 h-6" />
            </a>
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                    {{ $canteen->name }}
                </h2>
                @if($canteen->description)
                    <p class="text-sm text-gray-500">{{ $canteen->description }}</p>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="createCartManager({ canteenId: {{ $canteen->id }} })">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Menu Section (Left) --}}
                <div class="flex-1">
                    {{-- Category Filter --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-4">
                            <div class="flex gap-2 flex-wrap">
                                <button @click="activeCategory = null"
                                        :class="activeCategory === null ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-600'"
                                        class="px-4 py-2 rounded-full text-sm font-medium transition">
                                    Semua
                                </button>
                                @foreach($categories as $category)
                                    <button @click="activeCategory = '{{ $category }}'"
                                            :class="activeCategory === '{{ $category }}' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-600'"
                                            class="px-4 py-2 rounded-full text-sm font-medium transition">
                                        {{ $category }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Menu Grid --}}
                    @if($menuItems->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($menuItems as $item)
                                @php
                                    $imageUrl = $item->image
                                        ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image))
                                        : '';
                                @endphp
                                <div x-show="activeCategory === null || activeCategory === '{{ $item->category }}'"
                                     x-transition
                                     class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                                    {{-- Image (Top) --}}
                                    <div class="w-full h-40 relative">
                                        @if($item->image)
                                            <img src="{{ $imageUrl }}"
                                                 alt="{{ $item->name }}"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center\'><svg class=\'w-12 h-12 text-red-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center">
                                                <x-icons.image-placeholder class="w-12 h-12 text-red-400" />
                                            </div>
                                        @endif
                                        {{-- Category Badge (Overlay) --}}
                                        @if($item->category)
                                            <span class="absolute top-2 right-2 text-xs bg-white/90 backdrop-blur-sm text-gray-700 px-2 py-1 rounded-full shadow-sm font-medium">
                                                {{ $item->category }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Info (Bottom) --}}
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $item->name }}</h4>
                                            @if($item->description)
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                                            @endif
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-gray-100 space-y-3">
                                            {{-- Price --}}
                                            <div class="text-center">
                                                <span class="font-bold text-red-600 text-xl">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            {{-- Add to Cart Button --}}
                                            <template x-if="!getItemQuantity({{ $item->id }})">
                                                <button @click="addItem({
                                                    id: {{ $item->id }},
                                                    name: '{{ addslashes($item->name) }}',
                                                    price: {{ $item->price }},
                                                    image: '{{ $imageUrl }}'
                                                })"
                                                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                                    <x-icons.plus class="w-4 h-4 mr-1" />
                                                    Tambah ke Keranjang
                                                </button>
                                            </template>

                                            {{-- Quantity Controls --}}
                                            <template x-if="getItemQuantity({{ $item->id }})">
                                                <div class="flex items-center justify-center gap-4">
                                                    <button @click="decrementItem({{ $item->id }})"
                                                            class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition">
                                                        <x-icons.minus class="w-5 h-5" />
                                                    </button>
                                                    <span class="w-12 text-center font-bold text-lg" x-text="getItemQuantity({{ $item->id }})"></span>
                                                    <button @click="incrementItem({{ $item->id }})"
                                                            class="w-10 h-10 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white transition">
                                                        <x-icons.plus class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <x-order-empty-state
                                icon="cart"
                                title="Tidak ada menu"
                                description="Kantin ini belum memiliki menu yang tersedia."
                            />
                        </div>
                    @endif
                </div>

                {{-- Cart Section (Right/Sticky) --}}
                @include('orders.partials.cart-sidebar', ['canteen' => $canteen])
            </div>
        </div>
    </div>
</x-app-layout>
