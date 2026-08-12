<?php

namespace App\Models;

use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Store extends Model
{
    /** @use HasFactory<StoreFactory> */
    use HasFactory;

    const RESERVED_SLUGS = [
        'admin', 'login', 'logout', 'register', 'categories', 'deals',
        'search', 'products', 'storage', 'build', 'up', 'whatsapp', 'api',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'bio',
        'avatar_path',
        'cover_path',
        'location',
        'whatsapp_number',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Store $store) {
            if (empty($store->slug)) {
                $store->slug = static::uniqueSlug($store->name);
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'shop';
        $slug = $base;
        $i = 2;

        while (in_array($slug, self::RESERVED_SLUGS, true) || static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? asset('storage/'.$this->avatar_path) : null;
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? asset('storage/'.$this->cover_path) : null;
    }
}
