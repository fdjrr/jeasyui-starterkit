<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductUnit>
 */
use App\Models\User;

class ProductUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->unique()->randomNumber(3),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null, // Can be null as it's soft deletes
        ];
    }
}
