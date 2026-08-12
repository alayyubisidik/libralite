<?php

namespace Database\Factories;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->unique()->sentence(4),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'publication_year' => fake()->numberBetween(1990, (int) now()->year),
            'stock' => fake()->numberBetween(1, 10),
            'description' => fake()->optional()->paragraph(),
            'status' => BookStatus::Active,
        ];
    }

    /**
     * Indicate that the book is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BookStatus::Inactive,
        ]);
    }

    /**
     * Indicate that the book has no stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }
}
