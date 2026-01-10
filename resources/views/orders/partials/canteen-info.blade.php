@props(['canteen', 'showOrderAgain' => true])

@php
use Illuminate\Support\Facades\Storage;
@endphp

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                @if($canteen->image)
                    @php
                        $canteenImageUrl = str_starts_with($canteen->image, 'http')
                            ? $canteen->image
                            : Storage::url($canteen->image);
                    @endphp
                    <img src="{{ $canteenImageUrl }}"
                         alt="{{ $canteen->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <x-icons.image-placeholder class="w-8 h-8 text-gray-400" />
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900">{{ $canteen->name }}</h3>
                @if($canteen->category)
                    <span class="text-sm text-gray-500">{{ $canteen->category }}</span>
                @endif
            </div>
            @if($showOrderAgain)
                <a href="{{ route('canteen.menu', $canteen->slug) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 transition">
                    Pesan Lagi
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>
