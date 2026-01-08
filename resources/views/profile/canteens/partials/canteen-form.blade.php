<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        Informasi Kantin
    </h3>

    <div class="mb-6">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Foto Tempat Kantin (Banner)</label>
        <div class="relative w-full h-64 rounded-2xl overflow-hidden group border border-gray-200 shadow-sm">
            <img id="banner-preview"
                 src="{{ $canteen->image ? asset('storage/' . $canteen->image) : 'https://via.placeholder.com/800x400?text=Upload+Foto+Banner' }}" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            <label class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer text-white">
                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-bold text-sm">Ganti Foto Banner</span>
                <input type="file" name="canteen_photo" class="hidden" onchange="previewImage(this, 'banner-preview')">
            </label>
        </div>
    </div>

    <div class="mb-5">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Nama Kantin</label>
        <input type="text" name="canteen_name" value="{{ old('canteen_name', $canteen->name) }}" 
               class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Deskripsi</label>
        <textarea name="description" rows="5" 
                  class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all">{{ old('description', $canteen->description) }}</textarea>
    </div>

    <div class="mb-5">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Kategori (Pilih minimal 1)</label>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @php
                $currentCats = array_map('trim', explode(',', $canteen->category));
                $options = ['Makanan Berat', 'Minuman', 'Snack', 'Jajanan', 'Healthy Food', 'Cepat Saji', 'Dessert', 'Kopi'];
            @endphp

            @foreach($options as $cat)
                <label class="cursor-pointer relative">
                    <input type="checkbox" name="categories[]" value="{{ $cat }}" 
                        {{ in_array($cat, $currentCats) ? 'checked' : '' }}
                        class="peer sr-only">
                    <div class="p-3 rounded-2xl border border-gray-200 bg-white text-slate-600 text-sm font-bold text-center transition-all shadow-sm
                                peer-checked:bg-red-50 peer-checked:text-red-600 peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-500/20
                                hover:bg-slate-50 hover:shadow-md">
                        {{ $cat }}
                    </div>
                </label>
            @endforeach
        </div>
        @error('categories') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
    </div>
    
    <div class="mb-5">
        <div class="flex justify-between items-center mb-3">
            <label class="text-sm font-bold text-slate-600 ml-1">Titik Lokasi Kantin</label>
            <button type="button" onclick="getLocation()" class="text-[12px] bg-red-600 text-white px-4 py-1.5 rounded-full font-bold hover:bg-red-700 transition-all shadow-md">
                Perbarui Lokasi
            </button>
        </div>
        
        <div id="map" class="w-full h-[300px] rounded-2xl border border-gray-200 overflow-hidden shadow-inner relative z-0"></div>
        
        <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', $canteen->latitude ?? -6.9740) }}">
        <input type="hidden" name="longitude" id="lng" value="{{ old('longitude', $canteen->longitude ?? 107.6305) }}">
        
        <p class="text-[10px] text-slate-400 mt-2 ml-1">*Geser pin merah untuk mengubah lokasi kantin Anda secara manual.</p>
    </div>

    <div class="mb-5">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Keterangan Lokasi Tambahan</label>
        <input type="text" name="location_description" 
               value="{{ old('location_description', $canteen->location_description ?? '') }}"
               class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all" 
               placeholder="Contoh: Gedung Tokong Nanas, Lantai 1">
        <p class="text-[10px] text-slate-400 mt-2 ml-1">*Bantu pembeli menemukan posisi tepat kantin Anda.</p>
    </div>
</div>