<aside 
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 shadow-2xl md:shadow-xl transform transition-transform duration-300 ease-in-out flex flex-col justify-between"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="h-24 flex items-center px-8 border-b border-gray-50 bg-gradient-to-r from-white to-gray-50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group w-full">
            <img src="{{ asset('images/telyummy_logo.webp') }}" 
                 alt="Logo" 
                 class="w-16 h-16 object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-sm">
            <div>
                <span class="font-extrabold text-xl tracking-tight text-red-600">Telyummy</span>
                <p class="text-xs text-slate-500 font-medium tracking-wide">Kantin Digital Telyu</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
        
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 mt-2">Main Menu</p>

            <a href="{{ route('dashboard') }}" 
            class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('dashboard') 
            ? 'bg-red-600 font-semibold text-white shadow-lg shadow-red-500/30' 
            : 'text-slate-500 font-medium hover:bg-red-50 hover:text-red-600' }}">                
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="relative z-10">Dashboard</span>
            </a>
        </div>

        @if(Auth::user()->role === 'penjual')
        <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col space-y-3.5">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Manajemen Kantin</p>
            
            <a href="{{ route('menus.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('menus.*') 
            ? 'bg-red-600 font-semibold text-white shadow-lg shadow-red-500/30' 
            : 'text-slate-500 font-medium hover:bg-red-50 hover:text-red-600' }}">     
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="relative z-10">Daftar Menu</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('orders.*') 
            ? 'bg-red-600 font-semibold text-white shadow-lg shadow-red-500/30' 
            : 'text-slate-500 font-medium hover:bg-red-50 hover:text-red-600' }}">     
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span class="relative z-10">Pesanan Masuk</span>
                <span class="absolute right-4 w-5 h-5 bg-red-600 text-white text-[10px] font-bold flex items-center justify-center rounded-full shadow-md shadow-red-500/40 animate-pulse group-hover:bg-white group-hover:text-red-600 transition-colors">3</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative overflow-hidden {{ request()->routeIs('reports.*') 
            ? 'bg-red-600 font-semibold text-white shadow-lg shadow-red-500/30' 
            : 'text-slate-500 font-medium hover:bg-red-50 hover:text-red-600' }}">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="relative z-10">Laporan Penjualan</span>
            </a>
        </div>
        @endif

        {{-- TODO: Buat navigasi menu untuk pembeli disini --}}
        
    </nav>

    <div class="p-6 border-t border-gray-50 bg-gray-50/50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl text-slate-500 bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 hover:border-red-100 font-bold transition-all duration-300 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>