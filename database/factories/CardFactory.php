<?php

namespace Database\Factories;

use App\Models\OrgUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_number' => $this->faker->numerify('######'),
            'org_user_id' => null,
            'card_status' => 1,
        ];

    }
}
