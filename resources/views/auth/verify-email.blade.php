<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Kantin Telyu</title>
    
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
        
        <div class="text-center mb-6">
            <a href="/">
                <img src="{{ asset('images/telyummy_logo.webp') }}" alt="Logo" class="w-16 h-16 mx-auto mb-4">
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">Verifikasi Email</h1>
            <div class="text-slate-500 mt-3 text-sm font-medium leading-relaxed text-justify">
                Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan ke inbox Anda.
                <br><br>
                Jika tidak masuk, cek folder spam atau klik tombol di bawah.
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-600 text-sm font-bold text-center">
                Link verifikasi baru telah berhasil dikirim ke alamat email Anda.
            </div>
        @endif

        <div class="space-y-4 mt-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600 text-white py-3.5 rounded-2xl font-extrabold text-lg shadow-xl shadow-red-500/30 hover:bg-red-700 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center text-slate-400 text-sm font-bold hover:text-red-600 transition py-2">
                    Batal & Keluar (Log Out)
                </button>
            </form>
        </div>
    </div>
</body>
</html>