<div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Analitik Penjualan</h3>
            <p class="text-xs text-slate-400">Ringkasan pendapatan penjualan kantin</p>
        </div>
        
        <div class="relative">
            <select id="filterPeriod" 
                    class="appearance-none bg-none bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block pl-3 pr-10 py-2 cursor-pointer w-full focus:outline-none"
                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none; text-indent: 1px; text-overflow: '';">
                <option value="weekly" selected>Mingguan</option>
                <option value="monthly">Bulanan</option>
            </select>
            
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    <div id="salesChart" class="w-full min-h-[300px]"></div>
</div>