<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recipedia - Koleksi Kuliner</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-800 antialiased font-sans flex flex-col min-h-screen">
    <nav class="bg-white/80 backdrop-blur-md border-b border-stone-200 sticky top-0 z-50 transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('recipes.index') }}" class="text-stone-600 hover:text-orange-700 font-medium transition tracking-wide text-sm uppercase">Resep</a>
                    <a href="{{ route('dashboard') }}" class="text-stone-600 hover:text-orange-700 font-medium transition tracking-wide text-sm uppercase">Dapur Saya</a>
                </div>
                <div class="flex-shrink-0 flex items-center justify-center absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('home') }}" class="flex flex-col items-center group">
                        <span class="font-serif text-3xl font-bold text-stone-900 tracking-tight group-hover:text-orange-700 transition duration-300">Recipedia</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-orange-600 font-medium mt-1">Koleksi Kuliner</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ 
                        open: false,
                        query: '',
                        suggestions: [],
                        loading: false,
                        timer: null,
                        fetchSuggestions() {
                            if (this.query.length < 2) {
                                this.suggestions = [];
                                return;
                            }
                            clearTimeout(this.timer);
                            this.timer = setTimeout(() => {
                                this.loading = true;
                                fetch(`{{ route('recipes.search') }}?q=${encodeURIComponent(this.query)}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        this.suggestions = data;
                                        this.loading = false;
                                    })
                                    .catch(() => {
                                        this.loading = false;
                                    });
                            }, 300);
                        },
                        selectSuggestion(id) {
                            window.location.href = `/recipes/${id}`;
                        }
                    }">
                        <button @click="open = !open" class="text-stone-500 hover:text-orange-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-4 w-96 bg-white rounded-xl shadow-xl border border-stone-100 z-50">
                             <form action="{{ route('recipes.index') }}" method="GET" class="p-4 border-b border-stone-100">
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        x-model="query"
                                        @input="fetchSuggestions()"
                                        placeholder="Cari resep..." 
                                        class="flex-1 px-4 py-2 bg-stone-50 border border-stone-200 rounded-lg focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition text-sm"
                                        autofocus
                                    >
                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 bg-stone-900 text-white rounded-lg hover:bg-orange-600 transition text-sm font-medium"
                                    >
                                        Cari
                                    </button>
                                </div>
                            </form>
                            <div class="max-h-80 overflow-y-auto">
                                <template x-if="loading">
                                    <div class="p-4 text-center text-stone-500 text-sm">
                                        Mencari...
                                    </div>
                                </template>
                                <template x-if="!loading && query.length >= 2 && suggestions.length === 0">
                                    <div class="p-4 text-center text-stone-500 text-sm">
                                        Tidak ada resep ditemukan
                                    </div>
                                </template>
                                <template x-if="suggestions.length > 0">
                                    <div class="py-2">
                                        <div class="px-4 py-2 text-xs font-semibold text-stone-400 uppercase tracking-wider">
                                            Saran Resep
                                        </div>
                                        <template x-for="suggestion in suggestions" :key="suggestion.id">
                                            <button 
                                                @click="selectSuggestion(suggestion.id)"
                                                class="w-full px-4 py-3 hover:bg-stone-50 transition flex items-center gap-3 text-left"
                                            >
                                                <template x-if="suggestion.image_url">
                                                    <img :src="suggestion.image_url" :alt="suggestion.title" class="w-12 h-12 object-cover rounded-lg">
                                                </template>
                                                <template x-if="!suggestion.image_url">
                                                    <div class="w-12 h-12 bg-stone-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <span class="flex-1 text-sm font-medium text-stone-900" x-text="suggestion.title"></span>
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-5 py-2 bg-stone-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-orange-700 transition shadow-lg hover:shadow-orange-500/20">
                            <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Resep
                        </a>
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
                        <a href="{{ route('login') }}" class="text-stone-600 hover:text-orange-700 font-medium transition text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 bg-stone-900 text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-orange-700 transition shadow-lg hover:shadow-orange-500/20">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
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
    <main class="flex-grow">
        {{ $slot }}
    </main>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
