<div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col h-full group"
     x-data="{ available: {{ $menu->is_available }} }">
    
    {{-- Gambar --}}
    <div class="relative h-32 sm:h-48 bg-slate-100 overflow-hidden">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-300">
                <svg class="w-8 sm:w-10 h-8 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        <div class="absolute top-2 right-2">
            <span class="px-2 py-1 rounded-lg text-[10px] sm:text-xs font-bold shadow-sm border transition-all"
                  :class="available ? 'bg-green-50 text-green-600 border-green-200' : 'bg-red-50 text-red-600 border-red-200'"
                  x-text="available ? 'Tersedia' : 'Habis'">
            </span>
        </div>
    </div>

    {{-- Konten --}}
    <div class="p-3 sm:p-4 flex flex-col flex-1">
        <h3 class="font-bold text-xs sm:text-base text-slate-800 line-clamp-1 mb-1">{{ $menu->name }}</h3>
        <p class="text-slate-500 text-[10px] sm:text-sm line-clamp-2 mb-2">{{ $menu->description ?? '-' }}</p>
        
        <div class="mt-auto">
            <p class="text-red-600 font-bold text-sm sm:text-lg mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
            <div class="flex items-center gap-2">
                <button type="button" @click="toggleAvailability({{ $menu->id }}); available = !available"
                        class="relative inline-flex h-6 w-10 sm:h-7 sm:w-12 items-center rounded-full transition-colors duration-300 focus:outline-none flex-shrink-0"
                        :class="available ? 'bg-green-500' : 'bg-slate-300'">
                    <span class="inline-block h-4 w-4 sm:h-5 sm:w-5 transform rounded-full bg-white shadow-md transition-transform duration-300"
                          :class="available ? 'translate-x-5 sm:translate-x-6' : 'translate-x-1'"></span>
                </button>
                <button @click="openModal('edit', {{ $menu }})" 
                        class="flex-1 flex items-center justify-center gap-1 py-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors group/edit">
                    <span class="text-[10px] sm:text-xs font-bold">Edit</span>
                </button>
                <button @click="confirmDelete('{{ route('menus.destroy', $menu->id) }}')" 
                        class="flex-1 flex items-center justify-center gap-1 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors group/delete">
                    <span class="text-[10px] sm:text-xs font-bold">Hapus</span>
                </button>
            </div>
        </div>
    </div>
</div>