@props(['item'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ !$item->is_available ? 'opacity-60' : '' }}">
    {{-- Image --}}
    <div class="relative aspect-square">
        @php
            $imageUrl = $item->image
                ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image))
                : null;
        @endphp
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                <x-icons.image-placeholder class="w-12 h-12 text-gray-400" />
            </div>
        @endif
        {{-- Availability Badge --}}
        <div class="absolute top-2 right-2">
            @if($item->is_available)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Tersedia
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Habis
                </span>
            @endif
        </div>
        {{-- Category Badge --}}
        <div class="absolute top-2 left-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                {{ $item->category }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4">
        <h4 class="font-semibold text-gray-900 truncate">{{ $item->name }}</h4>
        <p class="text-red-600 font-bold mt-1">{{ $item->formatted_price }}</p>
        @if($item->description)
            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $item->description }}</p>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-2 mt-4">
            {{-- Toggle Availability --}}
            <form action="{{ route('menu-items.toggle', $item) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="p-2 rounded-lg {{ $item->is_available ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition"
                        title="{{ $item->is_available ? 'Tandai Habis' : 'Tandai Tersedia' }}">
                    @if($item->is_available)
                        <x-icons.ban class="w-4 h-4" />
                    @else
                        <x-icons.check class="w-4 h-4" />
                    @endif
                </button>
            </form>

            {{-- Edit --}}
            <a href="{{ route('menu-items.edit', $item) }}"
               class="p-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition"
               title="Edit">
                <x-icons.edit class="w-4 h-4" />
            </a>

            {{-- Delete --}}
            <form action="{{ route('menu-items.destroy', $item) }}" method="POST" class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition"
                        title="Hapus">
                    <x-icons.trash class="w-4 h-4" />
                </button>
            </form>
        </div>
    </div>
</div>
