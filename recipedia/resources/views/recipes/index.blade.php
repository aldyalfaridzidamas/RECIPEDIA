<x-layouts.app>
    <!-- Hero Section -->
    <div class="relative bg-stone-900 text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?q=80&w=2662&auto=format&fit=crop" class="w-full h-full object-cover opacity-40" alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/40 to-transparent"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 md:py-48 text-center">
            <span class="block text-orange-500 font-bold tracking-[0.2em] uppercase text-sm mb-4 animate-fade-in-up">Selamat Datang di Recipedia</span>
            <h1 class="font-serif text-5xl md:text-7xl font-bold mb-6 leading-tight animate-fade-in-up" style="animation-delay: 0.1s">
                Resep Pilihan untuk <br/> <span class="italic text-orange-500">Setiap Kesempatan</span>
            </h1>
            <p class="text-stone-300 text-lg md:text-xl max-w-2xl mx-auto mb-10 font-light leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s">
                Temukan koleksi mahakarya kuliner yang dibagikan oleh komunitas pecinta makanan kami yang penuh semangat.
            </p>
            @if(!request('search'))
                <div class="animate-fade-in-up" style="animation-delay: 0.3s">
                    <a href="#recipes" class="inline-flex items-center px-8 py-4 bg-orange-600 text-white font-bold rounded-full hover:bg-orange-700 transition transform hover:scale-105 shadow-lg shadow-orange-600/30">
                        Jelajahi Resep
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- Main Content -->
    <div id="recipes" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b border-stone-200 pb-6">
            <div>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-stone-900 mb-2">
                    @if(request('search'))
                        Hasil Pencarian
                    @else
                        Koleksi Terbaru
                    @endif
                </h2>
                <p class="text-stone-500">
                    @if(request('search'))
                        Ditemukan {{ $recipes->total() }} hasil untuk "{{ request('search') }}"
                    @else
                        Segar dari dapur
                    @endif
                </p>
            </div>
            @if(!request('search'))
                <div class="hidden md:block">
                    <a href="{{ route('recipes.index') }}" class="text-sm font-bold uppercase tracking-wider text-orange-600 hover:text-stone-900 transition">Lihat Semua &rarr;</a>
                </div>
            @endif
        </div>
        @if($recipes->count() > 0)
            <!-- Masonry Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @foreach($recipes as $recipe)
                    <x-recipe-card :recipe="$recipe" />
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $recipes->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-24 bg-white rounded-3xl border border-stone-100 shadow-sm">
                <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="font-serif text-2xl font-bold text-stone-900 mb-2">
                    @if(request('search'))
                        Tidak ada hasil ditemukan
                    @else
                        Dapur sedang sepi
                    @endif
                </h3>
                <p class="text-stone-500 mb-8 max-w-md mx-auto">
                    @if(request('search'))
                        Kami tidak dapat menemukan resep yang cocok dengan pencarian Anda. Coba kata kunci lain.
                    @else
                        Jadilah yang pertama membagikan mahakarya kuliner Anda kepada dunia.
                    @endif
                </p>
                @auth
                    <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-8 py-3 bg-stone-900 text-white font-bold rounded-full hover:bg-orange-600 transition shadow-lg">
                        Bagikan Resep
                    </a>
                @else
                    <a href="{{ route('recipes.index') }}" class="inline-flex items-center px-8 py-3 bg-stone-900 text-white font-bold rounded-full hover:bg-orange-600 transition shadow-lg">
                        Hapus Pencarian
                    </a>
                @endauth
            </div>
        @endif
    </div>
</x-layouts.app>
