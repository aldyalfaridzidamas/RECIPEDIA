@props(['recipe'])
<div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
    <!-- Image Container -->
    <a href="{{ route('recipes.show', $recipe) }}" class="block aspect-[4/5] overflow-hidden bg-stone-100 relative">
        @if($recipe->image_path)
            <img src="{{ $recipe->imageUrl }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        @else
            <div class="w-full h-full flex items-center justify-center bg-stone-100">
                <svg class="w-12 h-12 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <!-- Like Badge (Floating) -->
        <div class="absolute top-4 right-4 z-10">
            <div class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full flex items-center space-x-1.5 shadow-sm border border-white/50">
                <svg class="w-3.5 h-3.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-bold text-stone-800">{{ $recipe->likes_count ?? $recipe->likesCount() }}</span>
            </div>
        </div>
    </a>
    <!-- Content -->
    <div class="p-6">
        <div class="flex items-center space-x-2 mb-3">
            <span class="text-[10px] uppercase tracking-wider font-bold text-orange-600">Resep</span>
            <span class="text-stone-300">•</span>
            <span class="text-[10px] uppercase tracking-wider font-medium text-stone-500">{{ $recipe->created_at->format('M d') }}</span>
        </div>
        <h3 class="font-serif text-xl font-bold text-stone-900 mb-3 leading-tight group-hover:text-orange-700 transition-colors">
            <a href="{{ route('recipes.show', $recipe) }}">
                {{ $recipe->title }}
            </a>
        </h3>
        <p class="text-stone-500 text-sm line-clamp-2 mb-4 leading-relaxed font-light">
            {{ $recipe->excerpt }}
        </p>
        <!-- Author -->
        <div class="flex items-center justify-between pt-4 border-t border-stone-100">
            <div class="flex items-center space-x-2 relative z-10">
                <div class="w-6 h-6 bg-orange-100 text-orange-700 rounded-full flex items-center justify-center font-serif text-xs font-bold">
                    {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
                </div>
                <span class="text-xs font-medium text-stone-600">{{ $recipe->user->name }}</span>
            </div>
            <a href="{{ route('recipes.show', $recipe) }}" class="text-xs font-medium text-orange-600 group-hover:translate-x-1 transition-transform duration-300 hover:text-orange-700">Baca Selengkapnya &rarr;</a>
        </div>
    </div>
    @auth
        @if(auth()->id() === $recipe->user_id)
            <div class="absolute top-4 left-4 z-50">
                <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus resep ini?');" class="bg-white/90 backdrop-blur-sm p-2 rounded-full text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm border border-white/50" title="Hapus Resep">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        @endif
    @endauth
</div>
