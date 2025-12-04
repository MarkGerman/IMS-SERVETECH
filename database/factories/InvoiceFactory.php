<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'student_id' => $this->faker->numberBetween(1, 10),
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'status' => 'pending',
        ];
    }
}
