<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SupplierRating;

class SupplierRatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierRating::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
