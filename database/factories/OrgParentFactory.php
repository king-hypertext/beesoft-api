<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\OrgUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrgParent>
 */
class OrgParentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id'=> User::factory(),
            'org_user_id' => OrgUser::factory(),
            'organization_id' => Organization::factory(),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->numerify('##########'),
            'account_status' => 1,
        ];
    }
}
