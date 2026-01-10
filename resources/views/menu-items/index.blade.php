<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Kelola Menu') }}
            </h2>
            <a href="{{ route('menu-items.create') }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <x-icons.plus class="w-4 h-4 mr-2" />
                Tambah Menu
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

            {{-- Canteen Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="flex items-center gap-4">
                    @if($canteen->image)
                        @php
                            $canteenImageUrl = str_starts_with($canteen->image, 'http')
                                ? $canteen->image
                                : Storage::url($canteen->image);
                        @endphp
                        <img src="{{ $canteenImageUrl }}" alt="{{ $canteen->name }}"
                             class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                            <x-icons.building class="w-8 h-8 text-gray-400" />
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $canteen->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $menuItems->total() }} menu item</p>
                    </div>
                </div>
            </div>

            {{-- Menu Items Grid --}}
            @if($menuItems->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($menuItems as $item)
                        <x-menu-item-card :item="$item" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $menuItems->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <x-order-empty-state
                    icon="plus"
                    title="Belum ada menu"
                    message="Mulai dengan menambahkan menu pertama Anda."
                    :actionUrl="route('menu-items.create')"
                    actionLabel="Tambah Menu"
                />
            @endif
        </div>
    </div>
</x-app-layout>
