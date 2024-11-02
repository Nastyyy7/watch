<?php

namespace Database\Factories;

use App\Models\Product;
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
        $name = $this->faker->unique()->uuid();
        $extension = $this->faker->randomElement([
            'gif',
            'jpeg',
            'png',
            'webp',
        ]);
        $filename = "{$name}.{$extension}";
        return [
            'name' => $this->faker->unique()->word(),
            'photo' => $filename,
            'price' => $this->faker->randomFloat(2, 0.01, 999999999.99),
            'quantity' => $this->faker->numberBetween(1, 149),
            'available' => true,
            
        ];
    }
}
