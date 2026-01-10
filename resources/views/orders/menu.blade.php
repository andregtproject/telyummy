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
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($menuItems as $item)
                                @php
                                    $imageUrl = $item->image
                                        ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image))
                                        : '';
                                @endphp
                                <div x-show="activeCategory === null || activeCategory === '{{ $item->category }}'"
                                     x-transition
                                     class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="flex">
                                        {{-- Image --}}
                                        <div class="w-32 h-32 flex-shrink-0">
                                            @if($item->image)
                                                <img src="{{ $imageUrl }}"
                                                     alt="{{ $item->name }}"
                                                     class="w-full h-full object-cover"
                                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center\'><svg class=\'w-8 h-8 text-red-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center">
                                                    <x-icons.image-placeholder class="w-8 h-8 text-red-400" />
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 p-4 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-start justify-between">
                                                    <h4 class="font-semibold text-gray-900">{{ $item->name }}</h4>
                                                    @if($item->category)
                                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                                            {{ $item->category }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($item->description)
                                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                                                @endif
                                            </div>

                                            <div class="flex items-center justify-between mt-2">
                                                <span class="font-bold text-red-600">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </span>

                                                {{-- Add to Cart Button --}}
                                                <template x-if="!getItemQuantity({{ $item->id }})">
                                                    <button @click="addItem({
                                                        id: {{ $item->id }},
                                                        name: '{{ addslashes($item->name) }}',
                                                        price: {{ $item->price }},
                                                        image: '{{ $imageUrl }}'
                                                    })"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                                        <x-icons.plus class="w-4 h-4 mr-1" />
                                                        Tambah
                                                    </button>
                                                </template>

                                                {{-- Quantity Controls --}}
                                                <template x-if="getItemQuantity({{ $item->id }})">
                                                    <div class="flex items-center gap-2">
                                                        <button @click="decrementItem({{ $item->id }})"
                                                                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition">
                                                            <x-icons.minus class="w-4 h-4" />
                                                        </button>
                                                        <span class="w-8 text-center font-medium" x-text="getItemQuantity({{ $item->id }})"></span>
                                                        <button @click="incrementItem({{ $item->id }})"
                                                                class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white transition">
                                                            <x-icons.plus class="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
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
