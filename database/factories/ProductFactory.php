<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $price = fake()->numberBetween(10, 2000) * 1000;
        $hasDiscount = fake()->boolean(30);

        return [
            'store_id' => Store::factory(),
            'category_id' => Category::factory(),
            'name' => ucfirst(fake()->words(3, true)),
            'description' => fake()->paragraph(),
            'price' => $price,
            'discount_price' => $hasDiscount ? (int) round($price * 0.8) : null,
            'location' => fake()->randomElement(['Dar es Salaam', 'Arusha', 'Mwanza', null]),
            'availability' => fake()->randomElement(['in_stock', 'in_stock', 'in_stock', 'limited', 'out_of_stock']),
            'is_featured' => fake()->boolean(15),
            'is_deal' => $hasDiscount,
            'status' => 'published',
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function deal(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'] ?? fake()->numberBetween(10, 2000) * 1000;

            return [
                'is_deal' => true,
                'discount_price' => (int) round($price * 0.75),
            ];
        });
    }
}
