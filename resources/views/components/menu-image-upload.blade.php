@props([
    'name' => 'image',
    'label' => 'Foto',
    'required' => false,
    'currentImage' => null,
    'helpText' => 'PNG, JPG, JPEG maksimal 2MB'
])

<div x-data="{ imagePreview: {{ $currentImage ? "'" . Storage::url($currentImage) . "'" : 'null' }} }">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <div class="flex items-center gap-4">
        <div class="relative">
            <template x-if="imagePreview">
                <img :src="imagePreview" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200">
            </template>
            <template x-if="!imagePreview">
                <div class="w-32 h-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50">
                    <x-icons.photo class="w-8 h-8 text-gray-400" />
                </div>
            </template>
        </div>
        <div class="flex-1">
            <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*"
                   @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
            <p class="mt-1 text-xs text-gray-500">{{ $helpText }}</p>
        </div>
    </div>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
