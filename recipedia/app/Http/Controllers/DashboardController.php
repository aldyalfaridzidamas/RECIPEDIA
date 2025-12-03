<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $myRecipes = $user->recipes()
            ->withCount('likedBy as likes_count')
            ->latest()
            ->get();
        $likedRecipes = $user->likedRecipes()
            ->withCount('likedBy as likes_count')
            ->latest()
            ->get();
        $myComments = $user->comments()
            ->with('recipe')
            ->latest()
            ->take(10)
            ->get();
        $stats = [
            'total_recipes' => $myRecipes->count(),
            'total_likes_received' => $myRecipes->sum('likes_count'),
            'total_comments' => $user->comments()->count(),
            'total_liked_recipes' => $likedRecipes->count(),
        ];
        return view('dashboard', compact('user', 'myRecipes', 'likedRecipes', 'myComments', 'stats'));
    }
}
