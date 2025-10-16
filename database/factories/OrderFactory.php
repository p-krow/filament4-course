<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(OrderStatusEnum::cases());

        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'price' => $this->faker->numberBetween(45000, 500000),
            'status' => $status->value,
        ];
    }
}
