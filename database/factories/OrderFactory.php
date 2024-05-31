<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'number' => 'OR' . $this->faker->unique()->randomNumber(6),

            'address_id' => Address::factory(),


            'total_price' => $this->faker->randomFloat(2, 0, 999.99),
            'status' => $this->faker->randomElement(['processing', 'shipped', 'delivered', 'cancelled']),
            'customer_id' => Customer::factory(),
        ];
    }
}
