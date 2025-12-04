<?php

namespace Database\Factories;

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
            'name' => $this->faker->words(3, true),
            'category_id' => $this->faker->numberBetween(1,4), // Assuming 10 categories exist
            'brand' => $this->faker->company,
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'selling_price' => $this->faker->randomFloat(2, 15, 150),
            'quantity' => $this->faker->numberBetween(10, 100),
            'reorder_level' => $this->faker->numberBetween(5, 20),
            'barcode' => $this->faker->ean13,
            'description' => $this->faker->sentence,
        ];
    }
}
