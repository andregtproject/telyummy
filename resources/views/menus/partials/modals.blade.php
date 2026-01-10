{{-- MODAL FORM TAMBAH/EDIT --}}
<div x-show="formModalOpen" style="display: none;" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition.opacity>
    
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="formModalOpen = false"></div>

    {{-- Modal Content --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-y-auto max-h-[90vh]">
        
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-slate-100 px-6 sm:px-8 py-6 z-10 flex justify-between items-center">
            <div>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-800" x-text="editMode ? 'Edit Menu' : 'Tambah Menu Baru'"></h3>
                <p class="text-slate-500 text-sm mt-1">Isi informasi menu dengan lengkap</p>
            </div>
            <button @click="formModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 hover:bg-slate-50 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form :action="editMode ? '{{ url('menus') }}/' + form.id : '{{ route('menus.store') }}'" method="POST" enctype="multipart/form-data">
            @csrf
            <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

            <div class="px-6 sm:px-8 py-6 space-y-6">
                
                {{-- Upload Foto --}}
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Foto Menu</label>
                    <div class="relative w-full h-64 rounded-2xl overflow-hidden group border border-gray-200 shadow-sm bg-gray-50">
                        
                        {{-- Logic Preview Gambar --}}
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </template>

                        {{-- Logic Placeholder (Jika belum ada gambar) --}}
                        <template x-if="!imagePreview">
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="font-bold text-sm text-slate-500">Upload Foto</span>
                                <span class="text-[10px] mt-1 text-slate-400">Klik area ini untuk memilih foto</span>
                            </div>
                        </template>

                        {{-- Overlay & Input (Menutupi seluruh area agar bisa di-klik) --}}
                        <label class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-300 cursor-pointer"
                               :class="imagePreview ? 'bg-black/50 opacity-0 group-hover:opacity-100' : ''">
                            
                            {{-- Konten Overlay (Hanya muncul jika hover pada gambar yang sudah ada) --}}
                            <div x-show="imagePreview" class="text-white flex flex-col items-center">
                                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="font-bold text-sm">Ganti Foto</span>
                            </div>

                            <input type="file" name="image" class="hidden" accept="image/*" @change="previewImage" :required="!editMode">
                        </label>
                    </div>
                </div>

                {{-- Nama Menu --}}
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Nama Menu</label>
                    <input type="text" name="name" x-model="form.name" required
                        class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder:text-gray-300 font-medium" 
                        placeholder="Contoh: Ayam Geprek Sambal Matah">
                </div>

                {{-- Harga & Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Harga Satuan</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                            <input type="number" name="price" x-model="form.price" required
                                class="w-full pl-12 pr-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all font-bold text-slate-800" 
                                placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Status Ketersediaan</label>
                        <div class="flex items-center gap-4 h-[54px] px-5 border border-gray-200 rounded-2xl bg-slate-50">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" class="sr-only peer" x-model="form.is_available">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                <span class="ml-3 text-sm font-bold text-slate-600 peer-checked:text-green-600 transition-colors" x-text="form.is_available ? 'Tersedia' : 'Tidak Tersedia'"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Deskripsi Menu</label>
                    <textarea name="description" x-model="form.description" rows="4" required
                        class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all resize-none placeholder:text-gray-300"
                        placeholder="Jelaskan rasa, bahan utama, atau keunikan menu ini..."></textarea>
                    <p class="text-[10px] text-slate-400 mt-2 ml-1 text-right">*Maksimal 255 karakter</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="sticky bottom-0 bg-white border-t border-slate-100 px-6 sm:px-8 py-6">
                <div class="flex justify-end gap-3">
                    <button type="button" @click="formModalOpen = false" 
                        class="px-6 py-3 text-slate-500 font-bold hover:bg-slate-100 rounded-xl transition-all">
                        Batalkan
                    </button>
                    <button type="submit" 
                        class="px-6 py-4 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 shadow-xl shadow-red-500/30 transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2">
                        <span x-text="editMode ? 'Simpan Perubahan' : 'Simpan Menu'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div x-show="deleteModalOpen" style="display: none;" 
     class="fixed inset-0 z-[60] flex items-center justify-center p-4"
     x-transition.opacity>
    
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="deleteModalOpen = false"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 overflow-hidden transform transition-all scale-100"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Menu Ini?</h3>
            <p class="text-slate-500 text-sm mb-8">
                Tindakan ini tidak dapat dibatalkan. Menu yang dihapus akan hilang dari daftar penjualan secara permanen.
            </p>

            <form :action="deleteActionUrl" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="flex gap-3 justify-center">
                    <button type="button" @click="deleteModalOpen = false" 
                            class="flex-1 px-6 py-3 text-slate-600 font-bold bg-slate-100 rounded-2xl hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 text-white font-bold bg-red-600 rounded-2xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/30">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>