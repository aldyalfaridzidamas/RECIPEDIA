<x-layouts.app>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 text-center">
            <h1 class="font-serif text-4xl font-bold text-stone-900 mb-2">Bagikan Resep Anda</h1>
            <p class="text-stone-500">Inspirasi orang lain dengan kreasi kuliner Anda</p>
        </div>
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-stone-100">
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-8">
                @csrf
                <!-- Image Upload -->
                <div x-data="{ preview: null }" class="space-y-2">
                    <label class="block text-sm font-bold text-stone-900 uppercase tracking-wider">Gambar Resep</label>
                    <div class="relative group cursor-pointer">
                        <div class="aspect-video w-full rounded-2xl bg-stone-50 border-2 border-dashed border-stone-300 flex flex-col items-center justify-center overflow-hidden transition hover:border-orange-500 hover:bg-orange-50/10">
                            <template x-if="!preview">
                                <div class="text-center p-6">
                                    <svg class="mx-auto h-12 w-12 text-stone-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-stone-500">Klik untuk mengunggah foto</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])">
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Basic Info -->
                <div class="grid grid-cols-1 gap-8">
                    <div>
                        <label for="title" class="block text-sm font-bold text-stone-900 uppercase tracking-wider mb-2">Judul Resep</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="cth., Sup Tomat Kemangi Panggang Pedesaan" 
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition font-serif text-xl placeholder:text-stone-300">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-bold text-stone-900 uppercase tracking-wider mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" placeholder="Ceritakan kisah di balik hidangan ini..." 
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition resize-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Ingredients & Instructions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label for="ingredients" class="block text-sm font-bold text-stone-900 uppercase tracking-wider mb-2">
                            Bahan-bahan <span class="text-stone-400 font-normal normal-case">(Satu per baris)</span>
                        </label>
                        <textarea name="ingredients" id="ingredients" rows="12" placeholder="2 cangkir tepung&#10;1 sdt garam&#10;3 butir telur" 
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition resize-none font-mono text-sm">{{ old('ingredients') }}</textarea>
                        @error('ingredients')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="instructions" class="block text-sm font-bold text-stone-900 uppercase tracking-wider mb-2">
                            Instruksi
                        </label>
                        <textarea name="instructions" id="instructions" rows="12" placeholder="Langkah 1: Panaskan oven...&#10;&#10;Langkah 2: Campur bahan..." 
                            class="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition resize-none">{{ old('instructions') }}</textarea>
                        @error('instructions')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-stone-100">
                    <a href="{{ url()->previous() }}" class="px-6 py-3 text-stone-500 font-bold hover:text-stone-800 transition">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-stone-900 text-white font-bold rounded-full hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5">
                        Terbitkan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
