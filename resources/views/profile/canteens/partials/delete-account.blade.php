<div class="bg-red-50 p-8 rounded-2xl border border-red-100 mt-12 mb-12">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <h4 class="text-red-800 font-bold text-xl">Hapus Akun Kantin</h4>
            <p class="text-red-600/80 text-sm mt-1">Tindakan ini permanen. Semua data akan hilang selamanya.</p>
        </div>
        
        <button type="button" onclick="showDeleteModal()" 
                class="px-6 py-3 bg-white border border-red-200 text-red-600 font-bold rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
            Hapus Akun Saya
        </button>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-8 shadow-2xl relative">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Yakin hapus akun?</h3>
        <p class="text-slate-500 text-sm mb-6">Masukkan password Anda untuk mengonfirmasi penghapusan. Data tidak bisa dikembalikan.</p>
        
        <form action="{{ route('canteen.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <input type="password" name="password_confirmation" placeholder="Password Anda" required 
                   class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all mb-6">
            
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="hideDeleteModal()" 
                        class="px-6 py-3 text-slate-600 font-bold bg-slate-100 rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="px-6 py-3 text-white font-bold bg-red-600 rounded-2xl hover:bg-red-700 transition-all shadow-lg shadow-red-500/30">Ya, Hapus Permanen</button>
            </div>
        </form>
    </div>
</div>