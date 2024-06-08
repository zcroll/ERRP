<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\PersonalInfo;
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
            'supplier_type_id' => SupplierType::factory(),
            'supplier_rating_id' => Vendor::factory(),
            'address_id' => Address::factory(),
            'personal_info_id' => PersonalInfo::factory(),
        ];
    }
}
