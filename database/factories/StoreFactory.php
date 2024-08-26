<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'opening_hours' => $this->faker->time('H:i:s'), // Generate time only
            'closing_hours' => $this->faker->time('H:i:s'), // Generate time only
            "open_24_hours" => $this->faker->boolean(),
        ];
    }
}
