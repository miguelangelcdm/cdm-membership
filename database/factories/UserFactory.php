<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $superadminExists = User::whereHas('role', function ($query) {
            $query->where('name', 'superadmin');
        })->exists();

        $role = $superadminExists && fake()->randomElement(['superadmin', 'admin','member']) === 'superadmin'
            ? Role::inRandomOrder() -> where('name', '!=', 'superadmin')->first()
            : Role::inRandomOrder() -> first();

        $status = in_array($role->name, ['superadmin', 'admin', 'member']) ? 'approved' : 'pending';

        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'dni' => fake()->unique()->randomNumber(8,true),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => $role->id,
            'status' => $status,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
