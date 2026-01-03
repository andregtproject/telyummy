<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Kantin Telyu</title>
    
    <link rel="icon" href="{{ asset('images/telyummy_logo.webp') }}" type="image/webp">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="glass w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl shadow-red-500/10 border border-white/50">
        
        <div class="text-center mb-8">
            <a href="/">
                <img src="{{ asset('images/telyummy_logo.webp') }}" alt="Logo" class="w-16 h-16 mx-auto mb-4">
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">Lupa Password?</h1>
            <p class="text-slate-500 mt-2 text-sm font-medium leading-relaxed">
                Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-600 text-sm font-bold text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2 ml-1">Email Terdaftar</label>
                <input type="email" name="email" :value="old('email')" required autofocus 
                    class="w-full px-5 py-3.5 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all shadow-sm" placeholder="Masukkan alamat email Anda">
                @error('email') 
                    <p class="text-red-500 text-xs mt-1 ml-1 font-semibold">{{ $message }}</p> 
                @enderror
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-2xl font-extrabold text-lg shadow-xl shadow-red-500/30 hover:bg-red-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                Kirim Link Reset
            </button>

            <p class="text-center text-slate-500 text-sm font-medium mt-6">
                Ingat password Anda? <a href="{{ route('login') }}" class="text-red-600 font-bold hover:underline">Masuk Kembali</a>
            </p>
        </form>
    </div>
</body>
</html>