<div class="bg-white rounded-2xl p-6 mb-8 border border-gray-100 shadow-sm flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6">

    <a href="{{ route('canteen.edit') }}" 
        class="flex flex-col sm:flex-row items-center gap-5 w-full md:w-auto group cursor-pointer hover:bg-slate-50 p-2 -ml-2 rounded-xl transition-all duration-300">        
        <div class="w-16 h-16 rounded-2xl shadow-lg shadow-red-500/20 overflow-hidden shrink-0 border border-gray-100 group-hover:scale-105 transition-transform duration-300">
            <img src="{{ $canteen->image ? asset('storage/' . $canteen->image) : 'https://ui-avatars.com/api/?name='.urlencode($canteen->name).'&background=fee2e2&color=ef4444' }}" 
                 alt="{{ $canteen->name }}" 
                 class="w-full h-full object-cover">
        </div>
        
        <div>
            <div class="flex items-center gap-2">
                <h3 class="text-2xl font-bold text-slate-800 tracking-tight group-hover:text-red-600 transition-colors">
                    {{ $canteen->name }}
                </h3>
                <svg class="w-4 h-4 text-slate-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </div>

            <div class="flex items-center gap-3 mt-1">
                <span class="text-sm font-medium text-slate-500 flex items-center gap-1">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    {{ $canteen->category }}
                </span>
                
                <span class="w-1.5 h-1.5 rounded-full {{ ($canteen->is_open ?? false) ? 'bg-green-500' : 'bg-red-500' }}"></span>
                <span class="text-xs font-bold {{ ($canteen->is_open ?? false) ? 'text-green-600' : 'text-red-600' }}">
                    {{ ($canteen->is_open ?? false) ? 'BUKA' : 'TUTUP' }}
                </span>
            </div>
        </div>
    </a>

    <div class="flex items-center gap-4 bg-slate-50 px-5 py-3 rounded-xl border border-slate-100 w-full md:w-auto justify-between md:justify-start">
        <div class="text-right mr-2">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Operasional</p>
            <p class="font-bold text-slate-800 text-sm">
                 {{ ($canteen->is_open ?? false) ? 'Terima Pesanan' : 'Tidak Menerima' }}
            </p>
        </div>

        <form action="{{ route('canteen.toggle') }}" method="POST">
            @csrf
            <button type="submit" class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 {{ ($canteen->is_open ?? false) ? 'bg-green-500' : 'bg-slate-300' }}">
                 <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform duration-300 ease-in-out shadow-md {{ ($canteen->is_open ?? false) ? 'translate-x-7' : 'translate-x-1' }}"></span>
            </button>
        </form>
    </div>
</div>