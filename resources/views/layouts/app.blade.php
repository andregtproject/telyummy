<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telyummy') }}</title>
        <link rel="icon" href="{{ asset('images/telyummy_logo.webp') }}" type="image/webp">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        {{-- Alpine.js loaded via Vite (resources/js/app.js) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            [x-cloak] { display: none !important; }
            /* Hide scrollbar for Chrome, Safari and Opera */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            /* Hide scrollbar for IE, Edge and Firefox */
            .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-red-500 selection:text-white" x-data="{ sidebarOpen: false }">
        
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <div class="md:hidden bg-white border-b border-gray-100 p-4 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/telyummy_logo.webp') }}" alt="Logo" class="w-8 h-8">
                    <span class="font-bold text-lg text-red-600">Telyummy</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            @include('layouts.navigation')

            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
                 class="fixed inset-0 bg-slate-900/50 z-40 md:hidden backdrop-blur-sm"></div>

            <main class="flex-1 md:ml-72 p-4 md:p-8 pt-6 overflow-y-auto min-h-screen transition-all duration-300">
                
                @isset($header)
                    <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            {{ $header }}
                        </div>
                        
                        <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] uppercase tracking-wider text-red-500 font-bold mt-1">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-white font-bold shadow-md overflow-hidden">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fee2e2&color=ef4444' }}" 
                                    alt="{{ Auth::user()->name }}" 
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </header>
                @endisset

                <div class="animate-fade-in-up">
                    {{ $slot }}
                </div>

            </main>
        </div>

        @stack('scripts')
    </body>
</html>