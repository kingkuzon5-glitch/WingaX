<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductView;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductView>
 */
class ProductViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'product_id' => Product::factory(),
            'session_id' => fake()->uuid(),
            'created_at' => fake()->dateTimeBetween('-13 days', 'now'),
        ];
    }
}
