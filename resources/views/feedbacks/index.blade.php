<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Feedback Saya') }}
            </h2>
            <a href="{{ route('feedbacks.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tulis Feedback
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($feedbacks->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada feedback</h3>
                        <p class="mt-2 text-gray-500">Anda belum pernah memberikan feedback ke kantin manapun.</p>
                        <div class="mt-6">
                            <a href="{{ route('feedbacks.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Tulis Feedback Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Feedback List --}}
                <div class="space-y-4">
                    @foreach($feedbacks as $feedback)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        {{-- Header: Canteen Info --}}
                                        <div class="flex items-center gap-3 mb-3">
                                            @if($feedback->canteen->image)
                                                <img src="{{ Storage::url($feedback->canteen->image) }}" 
                                                     alt="{{ $feedback->canteen->name }}"
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                                    <span class="text-red-600 font-bold text-sm">
                                                        {{ substr($feedback->canteen->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $feedback->canteen->name }}</h3>
                                                <p class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>

                                        {{-- Rating --}}
                                        <div class="mb-3">
                                            <x-rating-stars :rating="$feedback->rating" size="sm" />
                                        </div>

                                        {{-- Content Preview --}}
                                        <p class="text-gray-700 text-sm line-clamp-2">{{ $feedback->content }}</p>

                                        {{-- Order Reference (if any) --}}
                                        @if($feedback->order)
                                            <p class="mt-2 text-xs text-gray-500">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    Pesanan #{{ $feedback->order->id }}
                                                </span>
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Status Badge & Action --}}
                                    <div class="flex flex-col items-end gap-2 ml-4">
                                        <x-feedback-status-badge :status="$feedback->status" />
                                        
                                        <a href="{{ route('feedbacks.show', $feedback) }}" 
                                           class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>

                                {{-- Response Preview (if any) --}}
                                @if($feedback->response)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="bg-gray-50 rounded-lg p-3">
                                            <p class="text-xs font-medium text-gray-500 mb-1">Tanggapan Penjual:</p>
                                            <p class="text-sm text-gray-700 line-clamp-2">{{ $feedback->response }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
