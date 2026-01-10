@props(['item'])

@php
use Illuminate\Support\Facades\Storage;

$imageUrl = null;
if ($item->menuItem && $item->menuItem->image) {
    $imageUrl = str_starts_with($item->menuItem->image, 'http')
        ? $item->menuItem->image
        : Storage::url($item->menuItem->image);
}
@endphp

<div class="p-4 flex items-start gap-4">
    {{-- Thumbnail --}}
    <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
        @if($imageUrl)
            <img src="{{ $imageUrl }}"
                 alt="{{ $item->menuItem->name }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <x-icons.image-placeholder class="w-6 h-6 text-gray-400" />
            </div>
        @endif
    </div>

    {{-- Item Info --}}
    <div class="flex-1 min-w-0">
        <h4 class="font-medium text-gray-900">
            {{ $item->menuItem ? $item->menuItem->name : 'Item dihapus' }}
        </h4>
        <p class="text-sm text-gray-500">
            Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
        </p>
        @if($item->notes)
            <p class="text-sm text-gray-400 mt-1 italic">
                "{{ $item->notes }}"
            </p>
        @endif
    </div>

    {{-- Subtotal --}}
    <div class="text-right">
        <p class="font-medium text-gray-900">
            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
        </p>
    </div>
</div>
