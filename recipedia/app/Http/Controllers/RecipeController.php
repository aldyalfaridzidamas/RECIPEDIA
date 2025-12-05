<?php
namespace App\Http\Controllers;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class RecipeController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Recipe::with(['user', 'likedBy'])
            ->withCount('likedBy as likes_count');
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ingredients', 'like', "%{$search}%")
                    ->orWhere('instructions', 'like', "%{$search}%");
            });
        }
        $recipes = $query->latest()->paginate(12);
        return view('recipes.index', compact('recipes'));
    }
    public function create()
    {
        return view('recipes.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $recipeData = [
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'ingredients' => $validated['ingredients'],
            'instructions' => $validated['instructions'],
            'image_path' => null,
        ];
        if ($request->hasFile('image')) {
            $recipeData['image_path'] = $request->file('image')->store('recipes', 'public');
        }
        $recipe = Recipe::create($recipeData);
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Resep berhasil dibuat!');
    }
    public function show(Recipe $recipe)
    {
        $recipe->load(['user', 'comments.user', 'likedBy']);
        $likesCount = $recipe->likedBy()->count();
        $isLiked = $recipe->isLikedBy(auth()->user());
        return view('recipes.show', compact('recipe', 'likesCount', 'isLiked'));
    }
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        return view('recipes.edit', compact('recipe'));
    }
    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $recipeData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'ingredients' => $validated['ingredients'],
            'instructions' => $validated['instructions'],
        ];
        if ($request->hasFile('image')) {
            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            $recipeData['image_path'] = $request->file('image')->store('recipes', 'public');
        }
        $recipe->update($recipeData);
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Resep berhasil diperbarui!');
    }
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        if ($recipe->image_path) {
            Storage::disk('public')->delete($recipe->image_path);
        }
        $recipe->delete();
        return redirect()->route('dashboard')
            ->with('success', 'Resep berhasil dihapus!');
    }

    public function downloadPdf(Recipe $recipe)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('recipes.pdf', compact('recipe'));
        return $pdf->download('resep-' . $recipe->id . '.pdf');
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $recipes = Recipe::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('ingredients', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'title', 'image_path']);

        return response()->json($recipes->map(function ($recipe) {
            return [
                'id' => $recipe->id,
                'title' => $recipe->title,
                'image_url' => $recipe->image_path ? asset('storage/' . $recipe->image_path) : null,
            ];
        }));
    }
}
