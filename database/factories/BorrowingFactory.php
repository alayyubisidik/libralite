<?php

namespace Database\Factories;

use App\Enums\BorrowingStatus;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Borrowing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowDate = fake()->dateTimeBetween('-2 months', 'now');
        $dueDate = (clone $borrowDate)->modify('+7 days');

        return [
            'user_id' => Member::factory()->member(),
            'book_id' => Book::factory(),
            'borrow_code' => fake()->unique()->numerify('BRW-########'),
            'borrow_date' => $borrowDate->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'status' => BorrowingStatus::Borrowed,
        ];
    }

    /**
     * Indicate that the borrowing has been returned.
     */
    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'returned_at' => now(),
            'status' => BorrowingStatus::Returned,
        ]);
    }

    /**
     * Indicate that the borrowing is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => now()->subDays(fake()->numberBetween(1, 10))->format('Y-m-d'),
            'status' => BorrowingStatus::Overdue,
        ]);
    }
}
