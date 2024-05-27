<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_code' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'name' => $this->faker->name(),
            'image' => $this->faker->regexify('[A-Za-z0-9]{500}'),
            'description' => $this->faker->text(),
            'unit_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'is_discontinued' => $this->faker->boolean(),
            'product_category_id' => ProductCategory::factory(),
        ];
    }
}
