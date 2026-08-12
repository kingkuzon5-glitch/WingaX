<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Store;
use App\Models\WhatsappClick;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WhatsappClick>
 */
class WhatsappClickFactory extends Factory
{
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'product_id' => Product::factory(),
            'created_at' => fake()->dateTimeBetween('-13 days', 'now'),
        ];
    }
}
