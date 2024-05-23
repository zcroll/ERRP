<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'employee_code' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'department_id' => Department::factory(),
            'job_title' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'hire_date' => $this->faker->dateTime(),
            'salary' => $this->faker->randomFloat(2, 0, 999999.99),
            'role_id' => Role::factory(),
            'address_id' => Address::factory(),
            'last_login' => $this->faker->dateTime(),
            'password' => $this->faker->password(),
            'deleted_at' => $this->faker->dateTime(),
        ];
    }
}
