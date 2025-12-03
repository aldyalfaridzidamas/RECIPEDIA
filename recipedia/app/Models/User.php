<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class)->latest();
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }
    public function likedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'likes')->withTimestamps();
    }
}
