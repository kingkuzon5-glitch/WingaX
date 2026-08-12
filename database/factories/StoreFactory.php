<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'bio' => fake()->sentence(15),
            'location' => fake()->randomElement(['Dar es Salaam', 'Arusha', 'Mwanza', 'Dodoma', 'Zanzibar']),
            'whatsapp_number' => '25571'.fake()->numerify('#######'),
            'tags' => fake()->randomElements(['Electronics', 'Fast Shipping', 'Fashion', 'Trusted Seller', 'Wholesale'], 2),
        ];
    }
}
