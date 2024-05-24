<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\SalesInvoice;

class SalesInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesInvoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_date' => $this->faker->dateTime(),
            'invoice_number' => $this->faker->word(),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'order_id' => Order::factory(),
        ];
    }
}
