<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'category_id' => 2,
            'code' => rand(100000, 999999),
            'supplier_id' => null,
            'buying_price' => rand(40, 150),
            'selling_price' => rand(160, 700),
            'buying_date' => '2024-'.rand(1, 12).'-'.rand(1, 30),
            'quantity' => rand(0, 100),
            'root' => fake()->title(),
            'created_at'=> now()
        ];
    }
}
