<?php

namespace Database\Factories;

use App\Enums\MemberStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the account is a library member.
     */
    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'member_code' => fake()->unique()->numerify('LIB-######'),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->date(),
            'member_status' => MemberStatus::Active,
            'joined_at' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the account is an inactive library member.
     */
    public function inactiveMember(): static
    {
        return $this->member()->state(fn (array $attributes) => [
            'member_status' => MemberStatus::Inactive,
        ]);
    }

    /**
     * Indicate that the account is an administrator (no member data).
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'member_code' => null,
            'phone' => null,
            'address' => null,
            'date_of_birth' => null,
            'member_status' => null,
            'joined_at' => null,
        ]);
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
