<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telyummy - Kantin Telyu</title>
    <link rel="icon" href="{{ asset('images/telyummy_logo.webp') }}" type="image/webp">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(10px); }
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#ef4444 0.5px, transparent 0.5px), radial-gradient(#ef4444 0.5px, #ffffff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.1;
        }

        input:focus { outline: none; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased selection:bg-red-500 selection:text-white">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 px-4 pt-4">
        <div class="glass max-w-7xl mx-auto px-6 py-3 rounded-full shadow-lg shadow-gray-200/50 border border-white/50 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <div class="w-14 h-14 flex items-center justify-center">
                    <img 
                        src="{{ asset('images/telyummy_logo.webp') }}" 
                        alt="Telyummy Logo"
                        class="w-full h-full object-contain"
                    >
                </div>
                <p class="font-bold text-xl tracking-tight text-red-600">
                    Telyummy
                </p>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-m font-semibold text-slate-500">
                <a href="#home" id="nav-home" class="nav-link hover:text-red-600 transition">Beranda</a>
                <a href="#list-kantin" id="nav-kantin" class="nav-link hover:text-red-600 transition">Kantin</a>
                <a href="#about" id="nav-about" class="nav-link hover:text-red-600 transition">Tentang Kami</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('register') }}" class="text-slate-600 font-bold text-sm hover:text-red-600 transition">Daftar</a>
                
                <a href="{{ route('login') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-slate-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <div id="home" class="relative pt-36 pb-20 lg:pt-48 lg:pb-32 overflow-hidden scroll-mt-32">
        <div class="absolute inset-0 z-0">
             <img src="https://images.unsplash.com/photo-1543353071-873f17a7a088?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-100">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-50 via-white/80 to-white/90"></div>
            <div class="absolute inset-0 hero-pattern"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-red-100 text-red-600 text-s font-bold tracking-wide mb-6 border border-red-200">
                Solusi Lapar Mahasiswa Telyu
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                Kantin Telyu di <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-500">Genggamanmu</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-600 mb-10 leading-relaxed">
                Skip antrian panjang. Pesan makan dari kelas, ambil saat matang. Hemat waktu istirahatmu.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#list-kantin" class="px-8 py-4 bg-red-600 text-white font-bold rounded-2xl shadow-xl shadow-red-500/30 hover:bg-red-700 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    Cari Makan Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div id="list-kantin" class="relative bg-white py-20 scroll-mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Pilihan Kantin</h2>
                    <p class="text-slate-500 mt-3 text-lg">Mau makan di kantin mana hari ini?</p>
                </div>
                
                <div class="relative w-full md:w-80">
                    <input type="text" placeholder="Cari kantin teknik..." class="w-full pl-12 pr-4 py-3 bg-white border border-red-200 rounded-2xl focus:outline-none focus:border-red-600 transition-colors text-slate-700 font-medium placeholder-gray-400 shadow-sm">
                    <svg class="w-6 h-6 text-red-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                
                @forelse($canteens as $canteen)
                <a href="/kantin/{{ $canteen->slug }}" class="group relative bg-white rounded-[2rem] border border-gray-100 hover:border-red-100 hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-500 cursor-pointer overflow-hidden flex flex-col h-full">
                    
                    <div class="h-64 overflow-hidden relative shrink-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
                        <img src="{{ $canteen->image ?? 'https://via.placeholder.com/800x600?text=No+Image' }}" alt="{{ $canteen->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        
                        <div class="absolute top-5 left-5 z-20">
                             @if($canteen->is_open)
                                <div class="px-4 py-1.5 bg-white/20 backdrop-blur-md border border-white/30 rounded-full flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    <span class="text-white text-xs font-bold tracking-wide">BUKA</span>
                                </div>
                            @else
                                <div class="px-4 py-1.5 bg-black/60 backdrop-blur-md border border-white/10 rounded-full flex items-center gap-2">
                                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                    <span class="text-white text-xs font-bold tracking-wide">TUTUP</span>
                                </div>
                            @endif
                        </div>

                        <div class="absolute bottom-5 left-5 z-20 flex items-center text-white">
                            <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <span class="ml-1 font-bold text-lg">{{ $canteen->rating }}</span>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-red-600 transition">{{ $canteen->name }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $canteen->description }}</p>
                        
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-xs font-bold text-red-600 bg-red-50 px-3 py-1.5 rounded-lg uppercase tracking-wider">
                                {{ $canteen->category }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gray-100 text-slate-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-5 h-5 transform -rotate-45 group-hover:rotate-0 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>

                @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16">
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Kantin Terdaftar</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Saat ini sistem belum memiliki data kantin. Silakan cek kembali nanti.</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>

    <div id="about" class="relative bg-slate-50 py-24 scroll-mt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="relative order-2 md:order-1">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-red-100 rounded-full opacity-50"></div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-orange-100 rounded-full opacity-50"></div>
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Mahasiswa Telkom" class="relative rounded-3xl shadow-2xl border-4 border-white rotate-1 hover:rotate-0 transition duration-500">
                </div>
                
                <div class="order-1 md:order-2">
                    <span class="text-red-600 font-bold tracking-wider uppercase text-sm mb-2 block">Tentang Kami</span>
                    <h2 class="text-4xl font-extrabold text-slate-900 mb-6">Dibuat Oleh Mahasiswa, <br>Untuk Mahasiswa.</h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-6">
                        Telyummy lahir dari keresahan antrian panjang di jam istirahat yang singkat. Kami adalah tim mahasiswa Sistem Informasi yang ingin mendigitalisasi pengalaman kuliner di kampus.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-slate-700">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Efisien waktu antar kelas</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Dukung UMKM kantin kampus</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Pesan mudah & tanpa antri</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-12 mt-0">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-red-600 mb-4">Telyummy</h2>
            <p class="text-slate-500 mb-8">Dibuat dengan ❤️ untuk mahasiswa Telkom University.</p>
            <p class="text-slate-400 text-sm">&copy; 2026 Telyummy Project.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('div[id]');
            const navLinks = document.querySelectorAll('.nav-link');

            const updateActiveNav = () => {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    // Deteksi posisi (offset -250px)
                    if (scrollY >= (sectionTop - 250)) {
                        current = section.getAttribute('id');
                    }
                });

                // Tambahan: Pastikan jika scroll di paling atas, 'home' selalu aktif
                // Ini mencegah bug jika offsetTop home sedikit meleset di layar tertentu
                if (window.scrollY < 50) {
                    current = 'home';
                }

                navLinks.forEach(link => {
                    link.classList.remove('text-red-600'); 
                    link.classList.add('text-slate-500'); 
                    
                    // Cek jika href link mengandung ID section yang aktif
                    if (link.getAttribute('href').includes(current)) {
                        link.classList.remove('text-slate-500');
                        link.classList.add('text-red-600'); 
                    }
                });
            };

            window.addEventListener('scroll', updateActiveNav);
            updateActiveNav();
        });
    </script>

</body>
</html>