<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Models\User;

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
            'name' => $this->faker->word(),
            'code' => $this->faker->unique()->randomNumber(5),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'product_category_id' => ProductCategory::factory(),
            'product_unit_id' => ProductUnit::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
