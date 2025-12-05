<x-layouts.app>
    <div class="bg-stone-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="font-serif text-4xl font-bold mb-2">Dapur Saya</h1>
                    <p class="text-stone-400">Kelola resep dan aktivitas Anda</p>
                </div>
                <div class="mt-6 md:mt-0 flex space-x-4">
                    <div class="text-center px-6 py-3 bg-white/10 rounded-2xl backdrop-blur-sm">
                        <span class="block text-2xl font-bold font-serif">{{ $stats['total_recipes'] }}</span>
                        <span class="text-xs uppercase tracking-wider text-stone-400">Resep</span>
                    </div>
                    <div class="text-center px-6 py-3 bg-white/10 rounded-2xl backdrop-blur-sm">
                        <span class="block text-2xl font-bold font-serif">{{ $stats['total_likes_received'] }}</span>
                        <span class="text-xs uppercase tracking-wider text-stone-400">Suka</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 pb-20" x-data="{ tab: 'myRecipes' }">
        <div class="bg-white rounded-3xl shadow-xl min-h-[500px]">
            <div class="flex border-b border-stone-100 px-8 pt-4 overflow-x-auto">
                <button 
                    @click="tab = 'myRecipes'" 
                    :class="tab === 'myRecipes' ? 'border-orange-500 text-orange-600' : 'border-transparent text-stone-500 hover:text-stone-800'"
                    class="pb-4 px-6 border-b-2 font-bold text-sm uppercase tracking-wider transition whitespace-nowrap"
                >
                    Resep Saya
                </button>
                <button 
                    @click="tab = 'likedRecipes'" 
                    :class="tab === 'likedRecipes' ? 'border-orange-500 text-orange-600' : 'border-transparent text-stone-500 hover:text-stone-800'"
                    class="pb-4 px-6 border-b-2 font-bold text-sm uppercase tracking-wider transition whitespace-nowrap"
                >
                    Favorit
                </button>
                <button 
                    @click="tab = 'myComments'" 
                    :class="tab === 'myComments' ? 'border-orange-500 text-orange-600' : 'border-transparent text-stone-500 hover:text-stone-800'"
                    class="pb-4 px-6 border-b-2 font-bold text-sm uppercase tracking-wider transition whitespace-nowrap"
                >
                    Aktivitas
                </button>
            </div>
            <div class="p-8 md:p-12">
                <div x-show="tab === 'myRecipes'" x-transition.opacity>
                    @if($myRecipes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($myRecipes as $recipe)
                                <div class="space-y-3">
                                    <x-recipe-card :recipe="$recipe" />
                                    <div class="flex gap-2">
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-lg transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <h3 class="font-serif text-xl font-bold text-stone-900 mb-2">Mulai Memasak</h3>
                            <p class="text-stone-500 mb-6">Anda belum membagikan resep apa pun.</p>
                            <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-6 py-2 bg-stone-900 text-white font-bold rounded-full hover:bg-orange-600 transition">
                                Buat Resep
                            </a>
                        </div>
                    @endif
                </div>
                <div x-show="tab === 'likedRecipes'" x-transition.opacity style="display: none;">
                    @if($likedRecipes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($likedRecipes as $recipe)
                                <x-recipe-card :recipe="$recipe" />
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-stone-500">Belum ada resep favorit.</p>
                        </div>
                    @endif
                </div>
                <div x-show="tab === 'myComments'" x-transition.opacity style="display: none;">
                    @if($myComments->count() > 0)
                        <div class="space-y-4 max-w-3xl">
                            @foreach($myComments as $comment)
                                <div class="bg-stone-50 p-6 rounded-2xl border border-stone-100 hover:border-orange-200 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <a href="{{ route('recipes.show', $comment->recipe) }}" class="font-bold text-stone-900 hover:text-orange-600 transition">
                                            {{ $comment->recipe->title }}
                                        </a>
                                        <span class="text-xs text-stone-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-stone-600 text-sm">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-stone-500">Belum ada komentar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
