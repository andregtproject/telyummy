<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('menu-items.index') }}"
               class="p-2 rounded-lg hover:bg-gray-100 transition">
                <x-icons.arrow-left class="w-5 h-5 text-gray-600" />
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Tambah Menu Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('menu-items.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    {{-- Image Upload --}}
                    <x-menu-image-upload
                        name="image"
                        label="Foto Menu"
                        :required="true"
                    />

                    {{-- Name --}}
                    <div>
                        <x-input-label for="name" :value="__('Nama Menu')" />
                        <span class="text-red-500">*</span>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name')" required autofocus
                                      placeholder="Contoh: Nasi Goreng Spesial" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Price --}}
                    <x-menu-price-input
                        name="price"
                        label="Harga (Rupiah)"
                        :value="old('price')"
                    />

                    {{-- Category --}}
                    <x-menu-category-autocomplete
                        :categories="$categories"
                        :initialValue="old('category', '')"
                    />

                    {{-- Description --}}
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="description" name="description" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                  placeholder="Deskripsi singkat tentang menu ini...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Availability --}}
                    <div class="flex items-center">
                        <input type="checkbox" name="is_available" id="is_available" value="1"
                               {{ old('is_available', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                        <label for="is_available" class="ml-2 text-sm text-gray-600">
                            Menu tersedia untuk dipesan
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('menu-items.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <x-icons.check class="w-4 h-4 mr-2" />
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
