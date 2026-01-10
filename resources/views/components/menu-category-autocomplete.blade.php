@props([
    'categories' => [],
    'initialValue' => ''
])

<div x-data="createCategoryAutocomplete(@js($categories), '{{ $initialValue }}')" class="relative">
    <x-input-label for="category" :value="__('Kategori')" />
    <span class="text-red-500">*</span>

    <input
        type="text"
        name="category"
        id="category"
        x-model="query"
        @input="filterCategories()"
        @focus="showDropdown = true"
        @click.away="showDropdown = false"
        @keydown.escape="showDropdown = false"
        @keydown.enter.prevent="selectFirstOrCreate()"
        @keydown.arrow-down.prevent="highlightNext()"
        @keydown.arrow-up.prevent="highlightPrev()"
        autocomplete="off"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
        placeholder="Ketik atau pilih kategori..."
        required
    >

    {{-- Dropdown --}}
    <div
        x-show="showDropdown && (filteredCategories.length > 0 || query.length > 0)"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-auto"
    >
        {{-- Existing categories --}}
        <template x-for="(cat, index) in filteredCategories" :key="cat">
            <div
                @click="selectCategory(cat)"
                :class="{ 'bg-red-50': highlightedIndex === index }"
                class="px-4 py-2 cursor-pointer hover:bg-red-50 flex items-center gap-2"
            >
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span x-text="cat"></span>
            </div>
        </template>

        {{-- Add new category option --}}
        <template x-if="query.length > 0 && !exactMatch">
            <div
                @click="addNewCategory()"
                :class="{ 'bg-green-50': highlightedIndex === filteredCategories.length }"
                class="px-4 py-2 cursor-pointer hover:bg-green-50 border-t border-gray-100 flex items-center gap-2 text-green-600"
            >
                <x-icons.plus class="w-4 h-4" />
                <span>Tambahkan "<span x-text="query" class="font-semibold"></span>" ke kategori</span>
            </div>
        </template>

        {{-- Empty state --}}
        <template x-if="filteredCategories.length === 0 && query.length === 0">
            <div class="px-4 py-3 text-gray-400 text-sm">
                Mulai ketik untuk mencari atau membuat kategori...
            </div>
        </template>
    </div>

    <x-input-error :messages="$errors->get('category')" class="mt-2" />
</div>
