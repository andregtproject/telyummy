@props([
    'rating' => 0,
    'interactive' => false,
    'name' => 'rating',
    'size' => 'md'
])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        'xl' => 'w-8 h-8',
    ];
    $starSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($interactive)
    {{-- Interactive Rating Input (untuk form) --}}
    <div x-data="{ rating: {{ $rating }}, hoverRating: 0 }" class="flex items-center gap-1">
        <input type="hidden" name="{{ $name }}" :value="rating">
        
        @for($i = 1; $i <= 5; $i++)
            <button
                type="button"
                @click="rating = {{ $i }}"
                @mouseenter="hoverRating = {{ $i }}"
                @mouseleave="hoverRating = 0"
                class="focus:outline-none transition-transform hover:scale-110"
                :class="{ 'transform scale-110': rating === {{ $i }} }"
            >
                <svg
                    class="{{ $starSize }} transition-colors duration-150"
                    :class="(hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                </svg>
            </button>
        @endfor
        
        <span class="ml-2 text-sm text-gray-600" x-text="rating > 0 ? rating + '/5' : 'Pilih rating'"></span>
    </div>
@else
    {{-- Static Rating Display (untuk tampilan saja) --}}
    <div class="flex items-center gap-0.5">
        @for($i = 1; $i <= 5; $i++)
            <svg
                class="{{ $starSize }} {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
        @endfor
        
        @if($rating > 0)
            <span class="ml-1 text-sm text-gray-600">({{ $rating }}/5)</span>
        @endif
    </div>
@endif
