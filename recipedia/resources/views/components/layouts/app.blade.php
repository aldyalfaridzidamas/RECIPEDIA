<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Recipedia') }} - {{ $title ?? 'Inspirasi Kuliner' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 antialiased font-sans flex flex-col min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-stone-200 sticky top-0 z-50 transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Left Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('recipes.index') }}" class="text-stone-600 hover:text-orange-700 font-medium transition tracking-wide text-sm uppercase">Resep</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-stone-600 hover:text-orange-700 font-medium transition tracking-wide text-sm uppercase">Dapur Saya</a>
                    @endauth
                </div>
                <!-- Logo (Centered) -->
                <div class="flex-shrink-0 flex items-center justify-center absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('home') }}" class="flex flex-col items-center group">
                        <span class="font-serif text-3xl font-bold text-stone-900 tracking-tight group-hover:text-orange-700 transition duration-300">Recipedia</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-orange-600 font-medium mt-1">Koleksi Kuliner</span>
                    </a>
                </div>
                <!-- Right Nav -->
                <div class="flex items-center space-x-6">
                    <!-- Search Trigger (Desktop) -->
                    <div class="hidden md:block relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-stone-500 hover:text-orange-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <!-- Search Dropdown -->
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-4 w-80 bg-white rounded-xl shadow-xl border border-stone-100 p-4 z-50">
                            <form action="{{ route('recipes.index') }}" method="GET">
                                <input type="text" name="search" placeholder="Cari resep..." class="w-full px-4 py-2 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition text-sm">
                            </form>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('recipes.create') }}" class="hidden md:inline-flex items-center px-5 py-2 bg-stone-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-orange-700 transition shadow-lg hover:shadow-orange-500/20">
                            <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Resep Baru
                        </a>
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-9 h-9 bg-orange-100 text-orange-700 rounded-full flex items-center justify-center font-serif font-bold text-lg border border-orange-200">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-stone-100 py-2 z-50">
                                <div class="px-4 py-3 border-b border-stone-100">
                                    <p class="text-sm font-medium text-stone-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-stone-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-700 transition">Beranda</a>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-700 transition">Dapur Saya</a>
                                <a href="{{ route('recipes.create') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-700 transition">Buat Resep</a>
                                <div class="border-t border-stone-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-stone-600 hover:text-orange-700 font-medium text-sm uppercase tracking-wide transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 border border-stone-300 text-stone-700 text-xs font-bold uppercase tracking-wider rounded-full hover:border-orange-700 hover:text-orange-700 transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-24 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="bg-white border-l-4 border-green-500 shadow-xl rounded-r-lg p-4 flex items-center pr-8 animate-fade-in-down">
                <div class="text-green-500 mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="font-medium text-stone-900">Berhasil</p>
                    <p class="text-sm text-stone-500">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>
    <!-- Footer -->
    <footer class="bg-white border-t border-stone-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="/" class="flex flex-col items-start group">
                        <span class="font-serif text-2xl font-bold text-stone-900 group-hover:text-orange-700 transition">Recipedia</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-orange-600 font-medium mt-1">Koleksi Kuliner</span>
                    </a>
                    <p class="mt-4 text-stone-500 text-sm leading-relaxed">
                        Temukan, bagikan, dan atur resep favorit Anda. Komunitas untuk pecinta makanan dan koki rumahan.
                    </p>
                </div>
                <div>
                    <h3 class="font-serif text-lg font-semibold text-stone-900 mb-4">Jelajahi</h3>
                    <ul class="space-y-2 text-sm text-stone-600">
                        <li><a href="{{ route('recipes.index') }}" class="hover:text-orange-600 transition">Semua Resep</a></li>
                        <li><a href="#" class="hover:text-orange-600 transition">Sedang Tren</a></li>
                        <li><a href="#" class="hover:text-orange-600 transition">Kategori</a></li>
                        <li><a href="#" class="hover:text-orange-600 transition">Koki</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-serif text-lg font-semibold text-stone-900 mb-4">Komunitas</h3>
                    <ul class="space-y-2 text-sm text-stone-600">
                        <li><a href="#" class="hover:text-orange-600 transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-orange-600 transition">Pedoman</a></li>
                        <li><a href="#" class="hover:text-orange-600 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-serif text-lg font-semibold text-stone-900 mb-4">Buletin</h3>
                    <p class="text-sm text-stone-500 mb-4">Inspirasi mingguan di kotak masuk Anda.</p>
                    <form class="flex">
                        <input type="email" placeholder="Alamat email" class="flex-1 px-4 py-2 bg-stone-50 border border-stone-200 rounded-l-lg focus:outline-none focus:border-orange-500 text-sm">
                        <button class="px-4 py-2 bg-stone-900 text-white text-sm font-medium rounded-r-lg hover:bg-orange-700 transition">
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-stone-100 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-stone-400">
                <p>&copy; {{ date('Y') }} Recipedia. Dibuat dengan hati.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-stone-600 transition">Privasi</a>
                    <a href="#" class="hover:text-stone-600 transition">Syarat</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
