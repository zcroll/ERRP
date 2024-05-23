<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\SupplierRating;
use App\Models\SupplierType;
use App\Models\Vendor;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'vendor_code' => $this->faker->word(),
            'business_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'contact_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'contact_email' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'contact_phone' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'supplier_type_id' => SupplierType::factory(),
            'supplier_rating_id' => SupplierRating::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
