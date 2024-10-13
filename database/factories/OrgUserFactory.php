<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrgUser>
 */
class OrgUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => 1,
            'department_id' => $this->faker->randomElement([6, 7, 8, 9, 10, 12]),
            'full_name' => $this->faker->name,
            'date_of_birth' => $this->faker->date,
            'mum_phone' => $this->faker->optional()->numerify('##########'),
            'dad_phone' => $this->faker->optional()->numerify('##########'),
            'email' => $this->faker->optional()->safeEmail,
            'parental_action' => $this->faker->sentence,
            'voice' => $this->faker->optional()->word,
            // 'is_admin' => $this->faker->boolean,
            // 'is_subadmin' => $this->faker->boolean,
        ];
    }
}
