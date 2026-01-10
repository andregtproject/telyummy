<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feedback Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                {{-- Total Feedback --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-gray-100 mr-4">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                            <p class="text-sm text-gray-500">Total Feedback</p>
                        </div>
                    </div>
                </div>

                {{-- Menunggu --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['menunggu'] }}</p>
                            <p class="text-sm text-gray-500">Menunggu</p>
                        </div>
                    </div>
                </div>

                {{-- Dibaca --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['dibaca'] }}</p>
                            <p class="text-sm text-gray-500">Dibaca</p>
                        </div>
                    </div>
                </div>

                {{-- Ditanggapi --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['ditanggapi'] }}</p>
                            <p class="text-sm text-gray-500">Ditanggapi</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Average Rating --}}
            @if($stats['average_rating'])
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-full bg-yellow-100">
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rating Rata-rata</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['average_rating'], 1) }} <span class="text-sm font-normal text-gray-500">/ 5</span></p>
                            </div>
                        </div>
                        <x-rating-stars :rating="round($stats['average_rating'])" size="lg" />
                    </div>
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
                        <p class="mt-2 text-gray-500">Anda belum menerima feedback dari pembeli.</p>
                    </div>
                </div>
            @else
                {{-- Feedback List --}}
                <div class="space-y-4">
                    @foreach($feedbacks as $feedback)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow {{ $feedback->status === 'menunggu' ? 'border-l-4 border-yellow-400' : '' }}">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        {{-- Header: User Info --}}
                                        <div class="flex items-center gap-3 mb-3">
                                            @if($feedback->user->avatar)
                                                <img src="{{ Storage::url($feedback->user->avatar) }}" 
                                                     alt="{{ $feedback->user->name }}"
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                                    <span class="text-red-600 font-bold text-sm">
                                                        {{ substr($feedback->user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $feedback->user->name }}</h3>
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
                                        
                                        <a href="{{ route('seller.feedbacks.show', $feedback) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 transition-colors">
                                            @if($feedback->status === 'menunggu')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                </svg>
                                                Tanggapi
                                            @else
                                                Lihat Detail
                                            @endif
                                        </a>
                                    </div>
                                </div>

                                {{-- Response Preview (if any) --}}
                                @if($feedback->response)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="bg-green-50 rounded-lg p-3">
                                            <p class="text-xs font-medium text-green-700 mb-1">Tanggapan Anda:</p>
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
