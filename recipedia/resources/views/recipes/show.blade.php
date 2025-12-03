<x-layouts.app>
    <!-- Immersive Header -->
    <div class="relative h-[60vh] min-h-[500px] w-full bg-stone-900 overflow-hidden">
        @if($recipe->image_path)
            <img src="{{ $recipe->imageUrl }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover opacity-60">
        @else
            <div class="w-full h-full bg-stone-800 flex items-center justify-center">
                <svg class="w-32 h-32 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
            <div class="max-w-5xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="animate-fade-in-up">
                        <div class="flex items-center space-x-3 text-white/80 mb-4 text-sm font-medium tracking-wider uppercase">
                            <span>{{ $recipe->created_at->format('d F Y') }}</span>
                            <span>&bull;</span>
                            <span>Oleh {{ $recipe->user->name }}</span>
                        </div>
                        <h1 class="font-serif text-4xl md:text-6xl font-bold text-white mb-4 leading-tight text-shadow-lg">
                            {{ $recipe->title }}
                        </h1>
                    </div>
                    <!-- Actions -->
                    <div class="flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 0.1s">
                        @auth
                            <button 
                                onclick="toggleLike({{ $recipe->id }})"
                                id="like-btn-{{ $recipe->id }}"
                                class="group flex items-center space-x-2 px-6 py-3 rounded-full transition-all duration-300 {{ $isLiked ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white/10 backdrop-blur-md text-white hover:bg-white/20' }}"
                            >
                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span id="like-count-{{ $recipe->id }}" class="font-bold">{{ $likesCount }}</span>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-10 pb-20">
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
            <!-- Description -->
            <div class="mb-12 border-b border-stone-100 pb-12">
                <p class="font-serif text-xl md:text-2xl text-stone-600 leading-relaxed italic text-center max-w-3xl mx-auto">
                    "{{ $recipe->description }}"
                </p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Ingredients -->
                <div class="lg:col-span-4">
                    <div class="bg-stone-50 rounded-2xl p-8 sticky top-24">
                        <h3 class="font-serif text-2xl font-bold text-stone-900 mb-6 flex items-center">
                            <span class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm mr-3">1</span>
                            Bahan-bahan
                        </h3>
                        <div class="space-y-4 text-stone-700 font-medium">
                            @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                                @if(trim($ingredient))
                                    <div class="flex items-start pb-3 border-b border-stone-200 last:border-0">
                                        <svg class="w-5 h-5 text-orange-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>{{ trim($ingredient) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Instructions -->
                <div class="lg:col-span-8">
                    <h3 class="font-serif text-2xl font-bold text-stone-900 mb-6 flex items-center">
                        <span class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm mr-3">2</span>
                        Instruksi
                    </h3>
                    <div class="prose prose-stone prose-lg max-w-none">
                        <div class="whitespace-pre-line text-stone-600 leading-loose">
                            {{ $recipe->instructions }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comments Section -->
        <div class="mt-12 max-w-3xl mx-auto">
            <h3 class="font-serif text-2xl font-bold text-stone-900 mb-8 text-center">Diskusi ({{ $recipe->comments->count() }})</h3>
            @auth
                <form action="{{ route('comments.store', $recipe) }}" method="POST" class="mb-12 bg-white p-6 rounded-2xl shadow-sm border border-stone-100">
                    @csrf
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-stone-900 text-white rounded-full flex items-center justify-center font-serif font-bold flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <textarea 
                                name="content" 
                                rows="3" 
                                placeholder="Bagikan pemikiran Anda atau ajukan pertanyaan..." 
                                class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition resize-none"
                                required
                            ></textarea>
                            <div class="flex justify-end mt-3">
                                <button type="submit" class="px-6 py-2 bg-stone-900 text-white font-bold text-sm rounded-full hover:bg-orange-600 transition">
                                    Kirim Komentar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-8 bg-stone-50 rounded-2xl mb-12">
                    <p class="text-stone-600">Silakan <a href="{{ route('login') }}" class="text-orange-600 font-bold hover:underline">masuk</a> untuk bergabung dalam percakapan.</p>
                </div>
            @endauth
            <div class="space-y-6">
                @foreach($recipe->comments as $comment)
                    <div class="flex space-x-4 group">
                        <div class="w-10 h-10 bg-orange-100 text-orange-700 rounded-full flex items-center justify-center font-serif font-bold flex-shrink-0 border border-orange-200">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="bg-white p-5 rounded-2xl rounded-tl-none shadow-sm border border-stone-100">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-bold text-stone-900">{{ $comment->user->name }}</span>
                                        <span class="text-xs text-stone-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @auth
                                        @if(auth()->id() === $comment->user_id || auth()->id() === $recipe->user_id)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-stone-300 hover:text-red-500 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="text-stone-600 leading-relaxed">{{ $comment->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @auth
    <script>
        function toggleLike(recipeId) {
            const btn = document.getElementById(`like-btn-${recipeId}`);
            const countSpan = document.getElementById(`like-count-${recipeId}`);
            fetch(`/recipes/${recipeId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                countSpan.textContent = data.likes_count;
                const svg = btn.querySelector('svg');
                if (data.liked) {
                    btn.classList.remove('bg-white/10', 'text-white', 'hover:bg-white/20');
                    btn.classList.add('bg-red-600', 'text-white', 'shadow-lg', 'shadow-red-600/30');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    btn.classList.remove('bg-red-600', 'shadow-lg', 'shadow-red-600/30');
                    btn.classList.add('bg-white/10', 'text-white', 'hover:bg-white/20');
                    svg.setAttribute('fill', 'none');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    @endauth
</x-layouts.app>
