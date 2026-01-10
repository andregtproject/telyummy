@props([
    'src' => null,
    'alt' => 'Image',
    'size' => 'md', // sm, md, lg
])

@php
use Illuminate\Support\Facades\Storage;

$sizeClasses = [
    'sm' => 'w-12 h-12',
    'md' => 'w-16 h-16',
    'lg' => 'w-24 h-24',
    'xl' => 'w-32 h-32',
    'full' => 'w-full h-48',
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];

// Detect if it's an external URL or storage path
$imageUrl = null;
if ($src) {
    $imageUrl = str_starts_with($src, 'http') ? $src : Storage::url($src);
}
@endphp

@if($imageUrl)
    <img 
        src="{{ $imageUrl }}" 
        alt="{{ $alt }}" 
        {{ $attributes->merge(['class' => "$sizeClass object-cover rounded-lg"]) }}
    >
@else
    <div {{ $attributes->merge(['class' => "$sizeClass bg-gray-200 rounded-lg flex items-center justify-center"]) }}>
        <x-icons.image-placeholder class="w-6 h-6 text-gray-400" />
    </div>
@endif
