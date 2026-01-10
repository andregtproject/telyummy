@props(['canteen'])

<div class="lg:w-96">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Keranjang</h3>
                <span class="text-sm text-gray-500" x-show="totalItems > 0">
                    <span x-text="totalItems"></span> item
                </span>
            </div>
        </div>

        {{-- Empty Cart --}}
        <div x-show="items.length === 0" class="p-8 text-center">
            <x-icons.cart class="mx-auto h-12 w-12 text-gray-300" />
            <p class="mt-2 text-sm text-gray-500">Keranjang masih kosong</p>
            <p class="text-xs text-gray-400 mt-1">Tambahkan menu untuk mulai pesan</p>
        </div>

        {{-- Cart Items --}}
        <div x-show="items.length > 0" class="max-h-80 overflow-y-auto">
            <template x-for="item in items" :key="item.id">
                <div class="p-4 border-b border-gray-50 flex items-center gap-3">
                    {{-- Thumbnail --}}
                    <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                        <template x-if="item.image">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!item.image">
                            <div class="w-full h-full flex items-center justify-center">
                                <x-icons.image-placeholder class="w-6 h-6 text-gray-400" />
                            </div>
                        </template>
                    </div>

                    {{-- Item Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate" x-text="item.name"></p>
                        <p class="text-red-600 text-sm font-medium" x-text="formatPrice(item.price * item.quantity)"></p>
                    </div>

                    {{-- Quantity --}}
                    <div class="flex items-center gap-1">
                        <button @click="decrementItem(item.id)"
                                class="w-6 h-6 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition">
                            <x-icons.minus class="w-3 h-3" />
                        </button>
                        <span class="w-6 text-center text-sm font-medium" x-text="item.quantity"></span>
                        <button @click="incrementItem(item.id)"
                                class="w-6 h-6 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white transition">
                            <x-icons.plus class="w-3 h-3" />
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Cart Footer --}}
        <div x-show="items.length > 0" class="p-4 bg-gray-50">
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-600">Total</span>
                <span class="text-lg font-bold text-gray-900" x-text="formatPrice(totalPrice)"></span>
            </div>

            <a :href="'{{ route('canteen.checkout', $canteen->slug) }}?cart=' + encodeURIComponent(JSON.stringify(items))"
               class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                <x-icons.cart class="w-5 h-5 mr-2" />
                Lanjut ke Checkout
            </a>
        </div>
    </div>
</div>
