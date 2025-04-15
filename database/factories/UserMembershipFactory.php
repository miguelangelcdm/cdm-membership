<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Membership;
use App\Models\UserMembership;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMembership>
 */
class UserMembershipFactory extends Factory
{
    protected $model = Usermembership::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $membershipId = Membership::inRandomOrder()->first()->id;
        return [
            'user_id' => User::factory(),
            'membership_id' => $membershipId,
            'starts_at' => $this->faker->dateTimeThisYear(),
            'expires_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
