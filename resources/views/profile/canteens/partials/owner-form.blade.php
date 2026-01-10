<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        Data Pemilik
    </h3>

    <div class="flex flex-col items-center mb-8">
        <div class="relative w-48 h-48 group">
            <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-lg ring-1 ring-gray-100">
                <img id="owner-preview" 
                     src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fee2e2&color=ef4444' }}" 
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
            </div>
            <label class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <input type="file" name="owner_photo" class="hidden" onchange="previewImage(this, 'owner-preview')">
            </label>
        </div>
        <p class="text-xs text-slate-400 mt-3 font-medium">Klik foto untuk mengganti</p>
    </div>

    <div class="mb-5">
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Nama Lengkap</label>
        <input type="text" name="owner_name" value="{{ old('owner_name', Auth::user()->name) }}" 
               class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all" required>
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Email</label>
        <input type="text" value="{{ Auth::user()->email }}" disabled 
               class="w-full px-5 py-3.5 bg-slate-50 text-slate-500 border border-gray-200 rounded-2xl cursor-not-allowed outline-none">
    </div>
</div>