<x-app-layout>
    <div x-data="menuHandler()">
        
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">Daftar Menu</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola menu makanan kantin Anda.</p>
            </div>
            
            <button @click="openModal('create')" 
                class="bg-red-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-red-700 shadow-lg shadow-red-500/30 transition-transform transform hover:scale-105 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Tambah Menu</span>
            </button>
        </div>

        {{-- GRID MENU --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
            @forelse($menus as $menu)
                {{-- Panggil Partial Card --}}
                @include('menus.partials.card')
            @empty
                <div class="col-span-full py-16 text-center border-gray-200 bg-slate-50/50 rounded-2xl border border-dashed ">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-gray-100">
                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-400">Belum ada menu</p>
                    <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Menu" untuk memulai.</p>
                </div>
            @endforelse
        </div>

        {{-- Panggil Semua Modal --}}
        @include('menus.partials.modals')

    </div>

    {{-- Script Handler --}}
    <script>
        function menuHandler() {
            return {
                formModalOpen: false,
                deleteModalOpen: false,
                deleteActionUrl: '',
                editMode: false,
                imagePreview: null,
                form: { id: '', name: '', price: '', description: '', is_available: true },

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.imagePreview = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                },

                openModal(mode, menu = null) {
                    this.editMode = mode === 'edit';
                    this.formModalOpen = true;
                    this.imagePreview = null;
                    if (this.editMode && menu) {
                        this.form = { 
                            id: menu.id, name: menu.name, price: menu.price, 
                            description: menu.description, is_available: menu.is_available == 1 
                        };
                        if(menu.image) this.imagePreview = '/storage/' + menu.image;
                    } else {
                        this.form = { id: '', name: '', price: '', description: '', is_available: true };
                    }
                },

                confirmDelete(url) {
                    this.deleteActionUrl = url;
                    this.deleteModalOpen = true;
                },

                toggleAvailability(id) {
                    fetch(`/menus/${id}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    }).then(res => res.json()).catch(err => console.error(err));
                }
            }
        }
    </script>
</x-app-layout>