<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'location',
        'availability',
        'reference',
        'is_featured',
        'is_deal',
        'status',
        'specs',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_deal' => 'boolean',
            'specs' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = static::uniqueSlug($product->name);
            }

            if (empty($product->reference)) {
                $product->reference = static::uniqueReference();
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public static function uniqueReference(): string
    {
        do {
            $reference = 'WX-'.random_int(1000, 9999);
        } while (static::where('reference', $reference)->exists());

        return $reference;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProductVideo::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }

    public function whatsappClicks(): HasMany
    {
        return $this->hasMany(WhatsappClick::class);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopeDeals(Builder $query): void
    {
        $query->where('is_deal', true);
    }

    public function hasDiscount(): bool
    {
        return ! is_null($this->discount_price) && bccomp((string) $this->discount_price, (string) $this->price, 2) < 0;
    }

    public function discountPercent(): int
    {
        if (! $this->hasDiscount()) {
            return 0;
        }

        return (int) round((1 - ((float) $this->discount_price / (float) $this->price)) * 100);
    }

    public function displayPrice(): string
    {
        return (string) ($this->hasDiscount() ? $this->discount_price : $this->price);
    }

    public function coverImage(): ?ProductImage
    {
        return $this->relationLoaded('images')
            ? $this->images->first()
            : $this->images()->first();
    }
}
