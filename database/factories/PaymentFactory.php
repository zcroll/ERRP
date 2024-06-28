<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'vendor_id' => Vendor::factory(),
            'customer_id' => Vendor::factory(),
            'payment_date' => $this->faker->dateTime(),
            'amount' => $this->faker->randomFloat(2, 100, 2000),
            'provider' => $this->faker->randomElement(['CIH', 'paypal', 'CHECK']),
            'method' => $this->faker->randomElement(['credit_card', 'bank_transfer', 'cash']),
        ];
    }
}
