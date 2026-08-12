<?php

namespace Database\Seeders;

use App\Enums\BorrowingStatus;
use App\Enums\FineStatus;
use App\Enums\PaymentStatus;
use App\Models\Attendance;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentDataSeeder extends Seeder
{
    private const FINE_RATE_PER_DAY = 2000;

    private const CATEGORIES = [
        'Fiksi' => 'Karya fiksi untuk pembaca umum.',
        'Non-fiksi' => 'Karya non-fiksi dan referensi umum.',
        'Sains & Teknologi' => 'Buku sains, teknologi, dan komputer.',
        'Sejarah' => 'Buku sejarah Indonesia dan dunia.',
        'Anak-anak' => 'Buku cerita dan pendidikan anak.',
        'Ekonomi & Bisnis' => 'Buku ekonomi, keuangan, dan bisnis.',
        'Novel' => 'Novel Indonesia dan terjemahan.',
        'Pendidikan' => 'Buku pendidikan dan pengajaran.',
        'Kesehatan' => 'Buku kesehatan dan gaya hidup.',
        'Agama' => 'Buku keagamaan dan spiritualitas.',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $this->seedCategoriesAndBooks();
        $this->seedMembers();
        $this->seedAttendances();
        $this->seedBorrowings();
    }

    private function seedCategoriesAndBooks(): void
    {
        foreach (self::CATEGORIES as $name => $description) {
            $category = Category::create([
                'name' => $name,
                'description' => $description,
            ]);

            Book::factory()
                ->count(fake()->numberBetween(2, 4))
                ->for($category)
                ->create();
        }
    }

    private function seedMembers(): void
    {
        User::factory()
            ->count(15)
            ->member()
            ->create()
            ->each
            ->assignRole('member');
    }

    private function seedAttendances(): void
    {
        $members = User::members()->get();

        foreach ($members->take(10) as $member) {
            foreach ($this->randomDistinctDates(fake()->numberBetween(2, 6)) as $date) {
                Attendance::factory()
                    ->for($member)
                    ->create(['check_in_date' => $date]);
            }
        }
    }

    private function randomDistinctDates(int $count): array
    {
        $dates = [];

        while (count($dates) < $count) {
            $dates[fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d')] = true;
        }

        return array_keys($dates);
    }

    private function seedBorrowings(): void
    {
        $members = User::members()->get();
        $books = Book::all();

        foreach ($members->take(8) as $member) {
            $this->createActiveBorrowing($member, $books->random());
        }

        foreach ($members->skip(8)->take(4) as $member) {
            $this->createOverdueBorrowing($member, $books->random());
        }

        $count = 0;
        foreach ($members->take(6) as $member) {
            $this->createReturnedBorrowing($member, $books->random(), $count++ % 2 === 0);
        }
    }

    private function createActiveBorrowing(User $member, Book $book): void
    {
        Borrowing::factory()
            ->for($member)
            ->for($book)
            ->create([
                'borrow_date' => now()->subDays(fake()->numberBetween(1, 5))->format('Y-m-d'),
                'due_date' => now()->addDays(fake()->numberBetween(2, 7))->format('Y-m-d'),
            ]);
    }

    private function createOverdueBorrowing(User $member, Book $book): void
    {
        $borrowing = Borrowing::factory()
            ->for($member)
            ->for($book)
            ->overdue()
            ->create();

        $overdueDays = max(1, (int) now()->startOfDay()->diffInDays($borrowing->due_date->startOfDay(), true));

        Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'overdue_days' => $overdueDays,
            'rate_per_day' => self::FINE_RATE_PER_DAY,
            'amount' => self::FINE_RATE_PER_DAY * $overdueDays,
            'status' => FineStatus::Unpaid,
        ]);
    }

    private function createReturnedBorrowing(User $member, Book $book, bool $late): void
    {
        $returnedAt = $late
            ? now()->subDays(fake()->numberBetween(5, 10))->startOfDay()
            : now()->subDays(fake()->numberBetween(15, 20))->startOfDay();

        $borrowDate = (clone $returnedAt)->subDays(fake()->numberBetween(8, 14));
        $dueDate = $late
            ? (clone $returnedAt)->subDays(fake()->numberBetween(1, 4))
            : (clone $returnedAt)->addDays(fake()->numberBetween(1, 5));

        $borrowing = Borrowing::factory()
            ->for($member)
            ->for($book)
            ->create([
                'borrow_date' => $borrowDate->format('Y-m-d'),
                'due_date' => $dueDate->format('Y-m-d'),
                'returned_at' => $returnedAt,
                'status' => BorrowingStatus::Returned,
            ]);

        if (! $late) {
            return;
        }

        $overdueDays = max(1, (int) $returnedAt->diffInDays($dueDate, true));

        $fine = Fine::factory()->create([
            'borrowing_id' => $borrowing->id,
            'overdue_days' => $overdueDays,
            'rate_per_day' => self::FINE_RATE_PER_DAY,
            'amount' => self::FINE_RATE_PER_DAY * $overdueDays,
            'status' => FineStatus::Paid,
        ]);

        Payment::factory()->create([
            'fine_id' => $fine->id,
            'user_id' => $borrowing->user_id,
            'amount' => $fine->amount,
            'status' => PaymentStatus::Paid,
            'paid_at' => $returnedAt->addMinutes(fake()->numberBetween(30, 600)),
        ]);
    }
}
