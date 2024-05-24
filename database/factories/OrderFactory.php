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
            'shipping_address_id' => ShippingAddress::factory(),
            'customer_id' => Customer::factory(),
            'order_status_id' => OrderStatus::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
