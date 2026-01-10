<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('feedbacks.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tulis Feedback') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('feedbacks.store') }}" method="POST" x-data="{ rating: 0 }">
                        @csrf

                        {{-- Pilih Kantin --}}
                        <div class="mb-6">
                            <x-input-label for="canteen_id" value="Pilih Kantin" />
                            <select 
                                id="canteen_id" 
                                name="canteen_id" 
                                class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">-- Pilih Kantin --</option>
                                @foreach($canteens as $canteen)
                                    <option value="{{ $canteen->id }}" {{ old('canteen_id', $selectedCanteen?->id) == $canteen->id ? 'selected' : '' }}>
                                        {{ $canteen->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('canteen_id')" class="mt-2" />
                        </div>

                        {{-- Pilih Pesanan (Opsional) --}}
                        @if($orders->isNotEmpty())
                            <div class="mb-6">
                                <x-input-label for="order_id" value="Terkait Pesanan (Opsional)" />
                                <select 
                                    id="order_id" 
                                    name="order_id" 
                                    class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                                >
                                    <option value="">-- Tidak terkait pesanan --</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}" {{ old('order_id', $selectedOrder?->id) == $order->id ? 'selected' : '' }}>
                                            Pesanan #{{ $order->id }} - {{ $order->canteen->name }} 
                                            ({{ $order->created_at->format('d M Y') }}) 
                                            - Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Pilih jika feedback terkait pesanan tertentu</p>
                                <x-input-error :messages="$errors->get('order_id')" class="mt-2" />
                            </div>
                        @endif

                        {{-- Rating --}}
                        <div class="mb-6">
                            <x-input-label value="Rating" />
                            <div class="mt-2">
                                <x-rating-stars :rating="old('rating', 0)" :interactive="true" name="rating" size="lg" />
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        {{-- Konten Feedback --}}
                        <div class="mb-6">
                            <x-input-label for="content" value="Isi Feedback" />
                            <textarea
                                id="content"
                                name="content"
                                rows="5"
                                class="mt-1 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                                placeholder="Ceritakan pengalaman Anda..."
                                required
                            >{{ old('content') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Minimal 10 karakter</p>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('feedbacks.index') }}" class="text-gray-600 hover:text-gray-800">
                                Batal
                            </a>
                            <x-primary-button class="bg-red-600 hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Feedback
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tips Box --}}
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Tips Menulis Feedback</h4>
                        <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                            <li>Berikan feedback yang jujur dan konstruktif</li>
                            <li>Jelaskan pengalaman Anda secara spesifik</li>
                            <li>Berikan saran untuk perbaikan jika ada</li>
                            <li>Hindari kata-kata kasar atau menyinggung</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
