<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\PaymentMethod;

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
            'payment_date' => $this->faker->dateTime(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'payment_method_id' => PaymentMethod::factory(),
        ];
    }
}
