@props([
    'name' => 'price',
    'label' => 'Harga (Rupiah)',
    'value' => '',
    'required' => true,
    'placeholder' => '15000'
])

<div>
    <x-input-label for="{{ $name }}" :value="__($label)" />
    @if($required)<span class="text-red-500">*</span>@endif
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm">Rp</span>
        </div>
        <input type="number" name="{{ $name }}" id="{{ $name }}"
               class="block w-full pl-12 pr-4 py-2 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
               value="{{ $value }}" @if($required) required @endif min="0" step="500"
               placeholder="{{ $placeholder }}">
    </div>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
