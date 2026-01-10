<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('seller.feedbacks.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Feedback') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Header: User Info --}}
                    <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            @if($feedback->user->avatar)
                                <img src="{{ Storage::url($feedback->user->avatar) }}" 
                                     alt="{{ $feedback->user->name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                                    <span class="text-red-600 font-bold text-xl">
                                        {{ substr($feedback->user->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $feedback->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $feedback->user->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Dikirim {{ $feedback->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        <x-feedback-status-badge :status="$feedback->status" />
                    </div>

                    {{-- Rating --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Rating</h4>
                        <x-rating-stars :rating="$feedback->rating" size="lg" />
                    </div>

                    {{-- Content --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Isi Feedback</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $feedback->content }}</p>
                        </div>
                    </div>

                    {{-- Order Reference --}}
                    @if($feedback->order)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Terkait Pesanan</h4>
                            <a href="{{ route('seller.orders.show', $feedback->order) }}" 
                               class="inline-flex items-center gap-2 bg-gray-50 hover:bg-gray-100 rounded-lg p-4 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900">Pesanan #{{ $feedback->order->id }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $feedback->order->created_at->format('d M Y') }} • 
                                        Rp {{ number_format($feedback->order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif

                    {{-- Mark as Read Button (if still menunggu) --}}
                    @if($feedback->status === 'menunggu')
                        <div class="mb-6">
                            <form action="{{ route('seller.feedbacks.status', $feedback) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="dibaca">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Tandai Sudah Dibaca
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Response Section --}}
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        @if($feedback->response)
                            {{-- Existing Response --}}
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900">Tanggapan Anda</h4>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $feedback->response }}</p>
                                @if($feedback->responded_at)
                                    <p class="mt-3 text-xs text-gray-500">
                                        Ditanggapi pada {{ $feedback->responded_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        @else
                            {{-- Response Form --}}
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900">Berikan Tanggapan</h4>
                            </div>

                            <form action="{{ route('seller.feedbacks.respond', $feedback) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <textarea
                                        name="response"
                                        rows="4"
                                        class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm"
                                        placeholder="Tulis tanggapan Anda untuk pembeli..."
                                        required
                                    >{{ old('response') }}</textarea>
                                    <x-input-error :messages="$errors->get('response')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end">
                                    <x-primary-button class="bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Kirim Tanggapan
                                    </x-primary-button>
                                </div>
                            </form>

                            {{-- Tips --}}
                            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800">Tips Menanggapi Feedback</h4>
                                        <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                                            <li>Ucapkan terima kasih atas feedback yang diberikan</li>
                                            <li>Tanggapi dengan sopan dan profesional</li>
                                            <li>Jika ada kritik, jelaskan langkah perbaikan yang akan dilakukan</li>
                                            <li>Tanggapan tidak dapat diubah setelah dikirim</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="mt-6">
                <a href="{{ route('seller.feedbacks.index') }}" 
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Feedback
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
