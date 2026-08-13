<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucwords(fake()->words(3, true)),
            'sku' => strtoupper(fake()->bothify('SKU-####??')),
            'price' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 1000),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
