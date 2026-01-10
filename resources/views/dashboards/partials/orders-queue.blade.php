@if(isset($incomingOrders) && $incomingOrders->count() > 0)
    <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col min-h-[500px] lg:min-h-0 lg:h-full">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-lg text-slate-800">Antrian Pesanan</h3>
        </div>

        <div class="space-y-3 overflow-y-auto pr-1 custom-scrollbar flex-1 h-0">
            @foreach($incomingOrders as $order)
            <div class="p-4 rounded-xl border border-gray-100 bg-slate-50 hover:bg-white hover:border-red-200 hover:shadow-md transition-all duration-300 group">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white border border-gray-200 text-slate-700 flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $order->user->name }}</h5>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-800 bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
                
                <button class="w-full py-2 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-red-600 transition shadow-sm flex items-center justify-center gap-2">
                    <span>Proses Pesanan</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            @endforeach
        </div>
    </div>
@else
    <div class="lg:col-span-1 flex items-center justify-center p-6 rounded-2xl border border-dashed border-gray-200 bg-slate-50/50 min-h-[400px] lg:min-h-0 lg:h-full">
        <div class="text-center">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-gray-100">
                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
            </div>
            <p class="text-sm font-bold text-slate-400">Antrian Kosong</p>
            <p class="text-xs text-slate-400 mt-1">Belum ada pesanan masuk saat ini.</p>
        </div>
    </div>
@endif