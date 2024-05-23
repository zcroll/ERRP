<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AuditLog;
use App\Models\Employee;
use App\Models\User;

class AuditLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AuditLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'table_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'action' => $this->faker->randomElement(["INSERT","UPDATE","DELETE"]),
            'old_value' => $this->faker->word(),
            'new_value' => $this->faker->word(),
            'employee_id' => Employee::factory(),
        ];
    }
}
