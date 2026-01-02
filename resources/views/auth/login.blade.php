<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Telyummy</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="glass w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl shadow-red-500/10 border border-white/50">
        <div class="text-center mb-8">
            <a href="/"><img src="{{ asset('images/telyummy_logo.webp') }}" alt="Logo" class="w-16 h-16 mx-auto mb-4"></a>
            <h1 class="text-3xl font-extrabold text-slate-900">Selamat Datang</h1>
            <p class="text-slate-500 mt-2 font-medium">Masuk untuk mulai memesan makanan</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Email</label>
                <input type="email" name="email" required autofocus class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div x-data="{ show: false }">
                <div class="flex justify-between mb-2 px-1">
                    <label class="text-sm font-bold text-slate-600">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-red-600 hover:underline">Lupa Password?</a>
                </div>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" required 
                        class="w-full px-5 py-3.5 bg-white border @error('password') border-red-500 @else @enderror rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all">
                    
                    <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-red-600 transition">
                        <svg x-show="!show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21.303 3m-2.691 2.691L17.5 7m-1.207 1.207L3 21.303"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411"/></svg>
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-[10px] mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-2xl font-extrabold text-lg shadow-xl shadow-red-500/30 hover:bg-red-700 transition-all active:scale-95">
                Masuk Sekarang
            </button>

            <p class="text-center text-slate-500 text-sm font-medium mt-6">
                Belum punya akun? <a href="{{ route('register') }}" class="text-red-600 font-bold hover:underline">Daftar di sini</a>
            </p>
        </form>
    </div>
</body>
</html>