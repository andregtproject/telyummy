<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('feedbacks.index') }}" class="text-gray-500 hover:text-gray-700">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Header: Canteen Info --}}
                    <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-4">
                            @if($feedback->canteen->image)
                                @php
                                    $imageUrl = str_starts_with($feedback->canteen->image, 'http')
                                        ? $feedback->canteen->image
                                        : Storage::url($feedback->canteen->image);
                                @endphp
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $feedback->canteen->name }}"
                                     class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-red-100 flex items-center justify-center">
                                    <span class="text-red-600 font-bold text-xl">
                                        {{ substr($feedback->canteen->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $feedback->canteen->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $feedback->canteen->category }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Dikirim {{ $feedback->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                        <x-feedback-status-badge :status="$feedback->status" />
                    </div>

                    {{-- Rating --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Rating Anda</h4>
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
                            <a href="{{ route('orders.show', $feedback->order) }}" 
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

                    {{-- Response from Seller --}}
                    @if($feedback->response)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900">Tanggapan Penjual</h4>
                            </div>
                            
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $feedback->response }}</p>
                                @if($feedback->responded_at)
                                    <p class="mt-3 text-xs text-gray-500">
                                        Ditanggapi pada {{ $feedback->responded_at->format('d M Y, H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Waiting for Response --}}
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-yellow-800">Menunggu Tanggapan</p>
                                        <p class="text-sm text-yellow-700">Feedback Anda sedang menunggu tanggapan dari penjual.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Back Button --}}
            <div class="mt-6">
                <a href="{{ route('feedbacks.index') }}" 
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
