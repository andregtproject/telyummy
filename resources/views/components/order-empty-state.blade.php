@props([
    'icon' => 'cart',
    'title' => 'Tidak ada data',
    'description' => 'Belum ada data untuk ditampilkan.',
    'actionUrl' => null,
    'actionLabel' => null,
])

<div {{ $attributes->merge(['class' => 'text-center py-12']) }}>
    <div class="flex justify-center mb-4">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
            @if($icon === 'cart')
                <x-icons.cart class="w-8 h-8 text-gray-400" />
            @elseif($icon === 'clock')
                <x-icons.clock class="w-8 h-8 text-gray-400" />
            @elseif($icon === 'check')
                <x-icons.check class="w-8 h-8 text-gray-400" />
            @else
                <x-icons.image-placeholder class="w-8 h-8 text-gray-400" />
            @endif
        </div>
    </div>
    
    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-500 mb-6">{{ $description }}</p>
    
    @if($actionUrl && $actionLabel)
        <a 
            href="{{ $actionUrl }}" 
            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
            {{ $actionLabel }}
        </a>
    @endif

    {{ $slot }}
</div>
