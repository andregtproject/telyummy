<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Telyummy - Kantin Telyu</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased selection:bg-red-500 selection:text-white">

    <div class="min-h-screen flex items-center justify-center p-4 py-12 bg-white bg-opacity-10">
        <div x-data="{ role: 'pembeli' }" class="glass w-full max-w-xl p-8 rounded-[2.5rem] shadow-2xl shadow-red-500/10 border border-white/50 relative overflow-hidden">
            
            <div class="text-center mb-8">
                <a href="/" class="inline-block mb-4">
                    <img src="{{ asset('images/telyummy_logo.webp') }}" alt="Logo" class="w-16 h-16 mx-auto">
                </a>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru</h1>
                <p class="text-slate-500 mt-2 font-medium">Bergabung dengan ekosistem kantin Telyu</p>
            </div>

            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="flex bg-gray-100/50 p-1.5 rounded-2xl mb-6 border border-gray-200">
                    <button type="button" @click="role = 'pembeli'" 
                        :class="role === 'pembeli' ? 'bg-white text-red-600 shadow-md' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        Sebagai Pembeli
                    </button>
                    <button type="button" @click="role = 'penjual'; $nextTick(() => initMap())" 
                        :class="role === 'penjual' ? 'bg-white text-red-600 shadow-md' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                        Sebagai Penjual
                    </button>
                </div>

                <input type="hidden" name="role" :value="role">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="Asep Ikram">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Email</label>
                        <input type="email" name="email" required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="asepikram@example.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Foto Profil</label>
                    <input type="file" name="avatar" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 cursor-pointer">
                </div>

                <div x-show="role === 'pembeli'" x-transition class="p-5 bg-red-50/50 border border-red-100 rounded-3xl">
                    <label class="block text-sm font-bold text-red-600 mb-2">Foto KTM / Kartu Pegawai</label>
                    <input type="file" name="identity_card" :required="role === 'pembeli'" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                    <p class="text-[10px] text-red-400 mt-2">*Hanya untuk validasi civitas akademik.</p>
                </div>

                <div x-show="role === 'penjual'" x-transition class="space-y-4 p-5 bg-red-50/30 border border-red-100 rounded-3xl">
                    <div>
                        <label class="block text-sm font-bold text-red-600 mb-2 ml-1">Nama Kantin</label>
                        <input type="text" name="canteen_name" :required="role === 'penjual'" class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="Contoh: Kantin GKU">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-red-600 mb-2 ml-1">Deskripsi Kantin</label>
                        <textarea name="description" rows="2" class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="Sebutkan menu andalan atau slogan kantin Anda"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-red-600 mb-2 ml-1">Foto Tempat Kantin</label>
                        <input type="file" name="canteen_image" :required="role === 'penjual'" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-sm font-bold text-red-600">Titik Lokasi Kantin</label>
                            <button type="button" onclick="getLocation()" class="text-[10px] bg-red-600 text-white px-4 py-1.5 rounded-full font-bold hover:bg-red-700 transition-all shadow-md">
                                Deteksi Lokasi
                            </button>
                        </div>
                        <div id="map" style="height: 250px;" class="rounded-2xl border-2 border-white shadow-lg overflow-hidden z-0"></div>
                        
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-red-600 mb-2 ml-1">Keterangan Lokasi Tambahan</label>
                        <input type="text" name="location_description" class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="Contoh: Gedung Tokong Nanas, Lantai 1">
                        <p class="text-[10px] text-red-400 mt-2">*Bantu pembeli menemukan posisi tepat kantin Anda.</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-2xl font-extrabold text-lg shadow-xl shadow-red-500/30 hover:bg-red-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 mt-4">
                    Daftar Sekarang
                </button>

                <p class="text-center text-slate-500 text-sm font-medium mt-6">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-red-600 font-bold hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        let map;
        let marker;
        const defaultLoc = [-6.9740, 107.6305]; // Telkom University

        function initMap(lat = defaultLoc[0], lng = defaultLoc[1]) {
            if (!map) {
                map = L.map('map').setView([lat, lng], 18);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                
                // PENTING: Set nilai input hidden saat peta pertama kali dimuat
                updateInputs(lat, lng);

                marker.on('dragend', function() {
                    let pos = marker.getLatLng();
                    updateInputs(pos.lat, pos.lng);
                });
            } else {
                map.setView([lat, lng], 18);
                marker.setLatLng([lat, lng]);
                updateInputs(lat, lng);
            }
        }

        function updateInputs(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        initMap(position.coords.latitude, position.coords.longitude);
                    },
                    () => {
                        alert("Gagal deteksi lokasi. Silakan geser pin secara manual.");
                        initMap();
                    },
                    { enableHighAccuracy: true }
                );
            }
        }
    </script>
</body>
</html>