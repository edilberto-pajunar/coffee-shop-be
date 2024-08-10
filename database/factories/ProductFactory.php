<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            "title" => fake()->text(10),
            "description" => fake()->text(100),
            "price" => fake()->randomFloat(2, 0, 1000),
            "popular" => fake()->boolean(),
            "category_id" => fake()->numberBetween(1, 3),
            "oz" => fake()->randomElement([8, 16])
            
        ];
    }
}
