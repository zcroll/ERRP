<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Customer;
use App\Models\CustomerType;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_code' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'name' => $this->faker->name(),
            'customer_type_id' => CustomerType::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
