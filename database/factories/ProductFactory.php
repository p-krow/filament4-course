<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(ProductStatusEnum::cases());

        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->optional()->paragraph(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'status' => $status->value,
            'is_active' => $this->faker->boolean(80),
            'category_id' => Category::factory(),
        ];
    }
}
