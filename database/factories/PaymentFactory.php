<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Fine;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fine_id' => Fine::factory(),
            'user_id' => Member::factory()->member(),
            'order_id' => fake()->unique()->numerify('ORDER-########'),
            'provider' => 'midtrans',
            'payment_type' => fake()->randomElement(['bank_transfer', 'gopay', 'credit_card', 'qris']),
            'amount' => fake()->randomFloat(2, 2000, 50000),
            'status' => PaymentStatus::Pending,
        ];
    }

    /**
     * Indicate that the payment was successful.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_id' => fake()->unique()->numerify('TRX-########'),
            'status' => PaymentStatus::Paid,
            'paid_at' => now(),
        ]);
    }

    /**
     * Indicate that the payment failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_id' => fake()->unique()->numerify('TRX-########'),
            'status' => PaymentStatus::Failed,
        ]);
    }
}
