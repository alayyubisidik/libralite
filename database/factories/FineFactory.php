<?php

namespace Database\Factories;

use App\Enums\FineStatus;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fine>
 */
class FineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Fine::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $overdueDays = fake()->numberBetween(1, 10);
        $ratePerDay = 2000;

        return [
            'borrowing_id' => Borrowing::factory(),
            'rate_per_day' => $ratePerDay,
            'overdue_days' => $overdueDays,
            'amount' => $ratePerDay * $overdueDays,
            'status' => FineStatus::Unpaid,
        ];
    }

    /**
     * Indicate that the fine has been paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FineStatus::Paid,
        ]);
    }

    /**
     * Indicate that the fine has been waived.
     */
    public function waived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FineStatus::Waived,
        ]);
    }
}
