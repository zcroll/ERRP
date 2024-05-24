<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\FinancialTransaction;
use App\Models\Payment;

class FinancialTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinancialTransaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction_date' => $this->faker->dateTime(),
            'type' => $this->faker->randomElement(["DEBIT","CREDIT"]),
            'payment_id' => Payment::factory(),
            'account_id' => Account::factory(),
        ];
    }
}
