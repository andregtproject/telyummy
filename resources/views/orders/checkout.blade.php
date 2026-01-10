<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('canteen.menu', $canteen->slug) }}" class="text-gray-400 hover:text-gray-600 transition">
                <x-icons.arrow-left class="w-6 h-6" />
            </a>
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">
                {{ __('Checkout') }} - {{ $canteen->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8" x-data="createCheckoutManager({
        canteenId: {{ $canteen->id }},
        storeUrl: '{{ route('orders.store') }}',
        csrfToken: '{{ csrf_token() }}',
        redirectUrl: '{{ route('orders.index') }}'
    })">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Empty Cart Warning --}}
            <template x-if="items.length === 0">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <x-order-empty-state
                        icon="cart"
                        title="Keranjang Kosong"
                        description="Tidak ada item di keranjang. Silakan pilih menu terlebih dahulu."
                        :actionUrl="route('canteen.menu', $canteen->slug)"
                        actionLabel="Kembali ke Menu"
                    />
                </div>
            </template>

            {{-- Checkout Form --}}
            <template x-if="items.length > 0">
                <form @submit.prevent="submitOrder" class="space-y-6">
                    {{-- Order Items --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Pesanan Kamu</h3>
                        </div>

                        <div class="divide-y divide-gray-50">
                            <template x-for="item in items" :key="item.id">
                                <div class="p-4 flex items-center gap-4">
                                    {{-- Thumbnail --}}
                                    <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                        <template x-if="item.image">
                                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!item.image">
                                            <div class="w-full h-full flex items-center justify-center">
                                                <x-icons.image-placeholder class="w-8 h-8 text-gray-400" />
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Item Info --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900" x-text="item.name"></p>
                                        <p class="text-sm text-gray-500">
                                            <span x-text="formatPrice(item.price)"></span> × <span x-text="item.quantity"></span>
                                        </p>
                                    </div>

                                    {{-- Quantity Controls --}}
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                                @click="decrementItem(item.id)"
                                                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition">
                                            <x-icons.minus class="w-4 h-4" />
                                        </button>
                                        <span class="w-8 text-center font-medium" x-text="item.quantity"></span>
                                        <button type="button"
                                                @click="incrementItem(item.id)"
                                                class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center text-white transition">
                                            <x-icons.plus class="w-4 h-4" />
                                        </button>
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="w-28 text-right">
                                        <p class="font-medium text-red-600" x-text="formatPrice(item.price * item.quantity)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Item Notes --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Catatan per Item (Opsional)</h3>
                            <p class="text-sm text-gray-500 mt-1">Tambahkan catatan khusus untuk setiap item</p>
                        </div>

                        <div class="divide-y divide-gray-50">
                            <template x-for="item in items" :key="'note-' + item.id">
                                <div class="p-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" x-text="item.name"></label>
                                    <input type="text"
                                           x-model="item.notes"
                                           placeholder="Contoh: tidak pedas, tanpa sayur..."
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Catatan Pesanan (Opsional)</h3>
                        </div>

                        <div class="p-4">
                            <textarea x-model="orderNotes"
                                      rows="3"
                                      placeholder="Catatan tambahan untuk penjual..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-900">Ringkasan Pesanan</h3>
                        </div>

                        <div class="p-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal (<span x-text="totalItems"></span> item)</span>
                                <span class="font-medium" x-text="formatPrice(totalPrice)"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kantin</span>
                                <span class="font-medium">{{ $canteen->name }}</span>
                            </div>
                            <hr class="my-3">
                            <div class="flex justify-between">
                                <span class="text-gray-900 font-semibold">Total Pembayaran</span>
                                <span class="text-xl font-bold text-red-600" x-text="formatPrice(totalPrice)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex gap-3">
                            <x-icons.clock class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" />
                            <div>
                                <p class="font-medium text-yellow-800">Pembayaran di Tempat</p>
                                <p class="text-sm text-yellow-700 mt-1">Pembayaran dilakukan langsung ke penjual saat mengambil pesanan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-between">
                        <a href="{{ route('canteen.menu', $canteen->slug) }}"
                           class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 transition">
                            <x-icons.arrow-left class="w-5 h-5 mr-2" />
                            Kembali ke Menu
                        </a>

                        <button type="submit"
                                :disabled="isSubmitting"
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <template x-if="!isSubmitting">
                                <span class="flex items-center">
                                    <x-icons.check class="w-5 h-5 mr-2" />
                                    Pesan Sekarang
                                </span>
                            </template>
                            <template x-if="isSubmitting">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </template>
                        </button>
                    </div>

                    {{-- Error Message --}}
                    <div x-show="errorMessage" x-transition class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex gap-3">
                            <x-icons.x-mark class="w-5 h-5 text-red-600 flex-shrink-0" />
                            <p class="text-red-800" x-text="errorMessage"></p>
                        </div>
                    </div>
                </form>
            </template>
        </div>
    </div>
</x-app-layout>
