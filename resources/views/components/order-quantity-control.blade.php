@props([
    'quantity' => 1,
    'itemId' => null,
    'min' => 0,
    'max' => 99,
])

<div {{ $attributes->merge(['class' => 'flex items-center space-x-2']) }}>
    <button 
        type="button"
        @click="decreaseQuantity({{ $itemId }})"
        :disabled="getQuantity({{ $itemId }}) <= {{ $min }}"
        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
    >
        <x-icons.minus class="w-4 h-4 text-gray-600" />
    </button>
    
    <span 
        x-text="getQuantity({{ $itemId }})"
        class="w-8 text-center font-medium text-gray-900"
    >{{ $quantity }}</span>
    
    <button 
        type="button"
        @click="increaseQuantity({{ $itemId }})"
        :disabled="getQuantity({{ $itemId }}) >= {{ $max }}"
        class="w-8 h-8 flex items-center justify-center rounded-full bg-red-500 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
    >
        <x-icons.plus class="w-4 h-4 text-white" />
    </button>
</div>
