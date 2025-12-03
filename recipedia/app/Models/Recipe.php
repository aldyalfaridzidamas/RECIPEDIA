<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Recipe extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'ingredients',
        'instructions',
        'image_path',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        return $this->likedBy()->where('user_id', $user->id)->exists();
    }
    public function likesCount(): int
    {
        return $this->likedBy()->count();
    }
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }
        return asset('storage/' . $this->image_path);
    }
    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit($this->description, 150);
    }
}
