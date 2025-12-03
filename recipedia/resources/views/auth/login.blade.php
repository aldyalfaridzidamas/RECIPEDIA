<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Recipedia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 antialiased font-sans h-screen flex overflow-hidden">
    <!-- Left Side (Image) -->
    <div class="hidden lg:block w-1/2 relative">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="Cooking">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute bottom-0 left-0 p-16 text-white">
            <h2 class="font-serif text-5xl font-bold mb-4">Selamat Datang Kembali</h2>
            <p class="text-lg text-white/90 max-w-md">Bergabunglah dengan komunitas pecinta makanan kami dan mulai bagikan perjalanan kuliner Anda hari ini.</p>
        </div>
    </div>
    <!-- Right Side (Form) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <span class="font-serif text-3xl font-bold text-stone-900">Recipedia</span>
                </a>
                <h1 class="text-2xl font-bold text-stone-900 mb-2">Masuk ke akun Anda</h1>
                <p class="text-stone-500 text-sm">Atau <a href="{{ route('register') }}" class="text-orange-600 hover:underline font-medium">buat akun baru</a></p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                        class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-700 mb-1">Kata Sandi</label>
                    <input id="password" type="password" name="password" required 
                        class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-stone-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-stone-600">Ingat saya</label>
                    </div>
                    <a href="#" class="text-sm text-orange-600 hover:underline font-medium">Lupa kata sandi?</a>
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-stone-900 text-white font-bold rounded-lg hover:bg-orange-600 transition shadow-lg">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
