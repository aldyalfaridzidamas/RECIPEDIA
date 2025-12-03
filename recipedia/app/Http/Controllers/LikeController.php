<?php
namespace App\Http\Controllers;
use App\Models\Recipe;
use Illuminate\Http\Request;
class LikeController extends Controller
{
    public function toggle(Recipe $recipe)
    {
        $user = auth()->user();
        if ($recipe->isLikedBy($user)) {
            $recipe->likedBy()->detach($user->id);
            $liked = false;
        } else {
            $recipe->likedBy()->attach($user->id);
            $liked = true;
        }
        $likesCount = $recipe->likedBy()->count();
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
        ]);
    }
}
