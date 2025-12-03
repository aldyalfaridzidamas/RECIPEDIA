<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $comment = $recipe->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);
        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $recipeId = $comment->recipe_id;
        $comment->delete();
        return redirect()->route('recipes.show', $recipeId)
            ->with('success', 'Komentar berhasil dihapus!');
    }
}
