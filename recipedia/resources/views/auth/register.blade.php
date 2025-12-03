<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Recipedia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 antialiased font-sans h-screen flex overflow-hidden">
    <!-- Left Side (Image) -->
    <div class="hidden lg:block w-1/2 relative">
        <img src="https://images.unsplash.com/photo-1507048331197-7d4ac70811cf?q=80&w=2574&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover" alt="Cooking">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute bottom-0 left-0 p-16 text-white">
            <h2 class="font-serif text-5xl font-bold mb-4">Bergabunglah Bersama Kami</h2>
            <p class="text-lg text-white/90 max-w-md">Buat akun untuk menyimpan resep favorit Anda dan bagikan kreasi Anda sendiri.</p>
        </div>
    </div>
    <!-- Right Side (Form) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <span class="font-serif text-3xl font-bold text-stone-900">Recipedia</span>
                </a>
                <h1 class="text-2xl font-bold text-stone-900 mb-2">Buat akun Anda</h1>
                <p class="text-stone-500 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-orange-600 hover:underline font-medium">Masuk</a></p>
            </div>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-stone-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                        class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
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
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                        class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition">
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-stone-900 text-white font-bold rounded-lg hover:bg-orange-600 transition shadow-lg">
                    Buat Akun
                </button>
            </form>
        </div>
    </div>
</body>
</html>
