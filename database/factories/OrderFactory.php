<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentMethod;
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
            'address_id' => Address::factory(),
            'total_price' => $this->faker->randomFloat(2, 0, 999.99),
            'status' => $this->faker->randomElement(['processing', 'shipped', 'delivered', 'cancelled']),
            'customer_id' => Customer::factory(),
            'payment_method_id' => PaymentMethod::factory(),
        ];
    }
}
