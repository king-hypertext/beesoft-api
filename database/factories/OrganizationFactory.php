<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserAccountStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'name' => $this->faker->company,
                'post_office_address' => $this->faker->address,
                'user_id' => 1,
                'activated_by' => 3,
                'category_id' => 1,
                'image' => $this->faker->imageUrl,
                'email' => $this->faker->unique()->safeEmail,
                'sms_api_key' => $this->faker->optional()->numerify('SMS-####-####'),
                'sms_api_secret_key' => $this->faker->optional()->numerify('SMS-####-####'),
                'sms_provider' => $this->faker->optional()->randomElement(['Twilio', 'Nexmo', 'MessageBird']),
                'manage_clock_in' => $this->faker->boolean,
                'signature_clock_in' => $this->faker->boolean,
                'account_status_id' => 1,    
        ];
    }
}
