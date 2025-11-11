<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
use App\Models\User;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->randomNumber(5),
            'name' => $this->faker->company(),
            'pic' => $this->faker->name(),
            'address' => $this->faker->address(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null, // Can be null as it's soft deletes
        ];
    }
}
