<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(0, 100),
            'unit_price' => $this->faker->randomFloat(2, 0, 999999.99),
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
