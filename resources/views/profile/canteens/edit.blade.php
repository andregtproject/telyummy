<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style> #map { z-index: 0; } </style>

    <div class="mb-8">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Edit Profil & Pengaturan Kantin</h2>
    </div>

    <form action="{{ route('canteen.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="flex flex-col gap-8">
                @include('profile.canteens.partials.owner-form')
                @include('profile.canteens.partials.password-form')
            </div>

            <div class="lg:col-span-2 flex flex-col gap-8">
                @include('profile.canteens.partials.canteen-form')
            </div>

        </div>

        <div class="flex justify-end mt-8 gap-4">
            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-6 py-3 text-slate-500 font-bold hover:bg-slate-100 rounded-xl transition-all text-center">
                    Batalkan
            </a>
            <button type="submit" class="bg-red-600 text-white font-bold py-4 px-10 rounded-2xl hover:bg-red-700 shadow-xl shadow-red-500/30 transition-all transform hover:scale-105 active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </form>

    @include('profile.canteens.partials.delete-account')

    @include('profile.canteens.partials.scripts')

</x-app-layout>