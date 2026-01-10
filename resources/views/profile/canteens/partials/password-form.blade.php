<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        Ganti Password
    </h3>
    <div class="space-y-5">
        
        <div x-data="{ show: false }">
            <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Password Saat Ini</label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'" name="current_password" 
                    class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all pr-12">
                
                <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-red-600 transition">
                    <svg x-show="!show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21.303 3m-2.691 2.691L17.5 7m-1.207 1.207L3 21.303"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411"/></svg>
                </button>
            </div>
            @error('current_password') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ show: false }">
            <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Password Baru</label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'" name="password" 
                    class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all pr-12">
                
                <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-red-600 transition">
                    <svg x-show="!show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21.303 3m-2.691 2.691L17.5 7m-1.207 1.207L3 21.303"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411"/></svg>
                </button>
            </div>
            @error('password') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ show: false }">
            <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Konfirmasi Password Baru</label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'" name="password_confirmation" 
                    class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all pr-12">
                
                <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-red-600 transition">
                    <svg x-show="!show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21.303 3m-2.691 2.691L17.5 7m-1.207 1.207L3 21.303"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411"/></svg>
                </button>
            </div>
            @error('password_confirmation') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
        </div>

        <p class="text-[10px] text-slate-400 ml-1">*Kosongkan semua kolom jika tidak ingin mengganti password</p>
    </div>
</div>