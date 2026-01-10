<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">

    {{-- CARD TOTAL PESANAN --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            
            @if(isset($incomingOrders) && $incomingOrders->count() > 0)
                <div class="text-right">
                    <span class="text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-lg animate-pulse shadow-sm shadow-red-200">
                        {{ $incomingOrders->count() }} Menunggu
                    </span>
                </div>
            @elseif($todaysOrderCount > 0)
                <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Semua Selesai
                </span>
            @else
                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                    Standby
                </span>
            @endif
        </div>

        <div>
            <p class="text-slate-500 font-medium text-sm">Total Pesanan Hari Ini</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-bold text-slate-800 mt-1">
                    {{ $todaysOrderCount }}
                </h4>
                <span class="text-sm font-medium text-slate-400 mb-1.5">Transaksi</span>
            </div>
            
            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-50">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ $todaysOrderCount > 0 ? 'bg-green-500' : 'bg-slate-300' }}"></span>
                    <p class="text-[10px] text-slate-500 font-bold">
                        {{ max(0, $todaysOrderCount - (isset($incomingOrders) ? $incomingOrders->count() : 0)) }} Selesai
                    </p>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ isset($incomingOrders) && $incomingOrders->count() > 0 ? 'bg-red-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    <p class="text-[10px] text-slate-500 font-bold">
                        {{ isset($incomingOrders) ? $incomingOrders->count() : 0 }} Antrian
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD PENDAPATAN --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-50 text-green-600 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a1 1 0 11-2 0 1 1 0 012 0z"></path>
                </svg>
            </div>
            
            @php
                $yesterday = $yesterdayRevenue ?? 0;
                $today = $dailyRevenue ?? 0;
                $diff = $today - $yesterday;
                
                if ($yesterday > 0) {
                    $percentage = round(($diff / $yesterday) * 100);
                } else {
                    $percentage = $today > 0 ? 100 : 0; 
                }
                
                $isUp = $diff >= 0;
            @endphp

            <span class="text-xs font-bold px-2 py-1 rounded-lg flex items-center gap-1 border transition-colors duration-300
                        {{ $isUp ? 'text-green-600 bg-green-50 border-green-100' : 'text-red-600 bg-red-50 border-red-100' }}">
                
                @if($isUp)
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +{{ $percentage }}% 
                @else
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    {{ $percentage }}% 
                @endif
                <span class="text-[9px] opacity-70 font-medium ml-0.5">vs kmrn</span>
            </span>
        </div>

        <div>
            <p class="text-slate-500 font-medium text-sm">Pendapatan Hari Ini</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">
                    Rp {{ number_format($dailyRevenue ?? 0, 0, ',', '.') }}
                </h4>
            </div>
            
            <div class="flex flex-col xl:flex-row xl:items-center gap-2 xl:gap-4 mt-3 pt-3 border-t border-slate-50">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <p class="text-[10px] text-slate-500 font-bold whitespace-nowrap">
                        Rp {{ number_format($weeklyRevenue ?? 0, 0, ',', '.') }} (Minggu Ini)
                    </p>
                </div>
                
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <p class="text-[10px] text-slate-500 font-bold whitespace-nowrap">
                        Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }} (Bulan Ini)
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- CARD RATING --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-yellow-50 text-yellow-500 rounded-xl group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            
            @if($rating > 0)
            <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-lg flex items-center gap-1 border border-yellow-100">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Aktif
            </span>
            @else
            <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100">
                Belum Ada
            </span>
            @endif
        </div>

        <div>
            <p class="text-slate-500 font-medium text-sm">Rating Kepuasan</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">
                    {{ number_format($rating, 1) }}
                </h4>
                <span class="text-sm font-medium text-slate-400 mb-1.5">/ 5.0</span>
            </div>
            
            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-slate-50">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ $totalReviews > 0 ? 'bg-yellow-500' : 'bg-slate-300' }}"></span>
                    <p class="text-[10px] text-slate-500 font-bold whitespace-nowrap">
                        {{ $totalReviews ?? 0 }} Orang Mengulas
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>