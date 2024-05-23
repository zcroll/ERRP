<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\ShippingAddress;

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
            'customer_id' => Customer::factory(),
            'order_status_id' => OrderStatus::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'subtotal' => $this->faker->randomFloat(2, 0, 99999999.99),
            'tax' => $this->faker->randomFloat(2, 0, 99999999.99),
            'shipping' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total' => $this->faker->randomFloat(2, 0, 99999999.99),
            'shipping_address_id' => ShippingAddress::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
