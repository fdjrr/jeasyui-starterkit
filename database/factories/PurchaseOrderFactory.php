<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
use App\Enums\PurchaseOrderStatus;
use App\Models\Supplier;
use App\Models\User;

class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'po_number' => $this->faker->unique()->randomNumber(8),
            'supplier_id' => Supplier::factory(),
            'order_date' => $this->faker->date(),
            'status' => PurchaseOrderStatus::DRAFT,
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
            'created_by' => User::factory()->create()->id,
        ];
    }
}
