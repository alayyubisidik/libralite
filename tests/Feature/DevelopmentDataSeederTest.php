<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\DevelopmentDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DevelopmentDataSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_runs_on_a_fresh_database(): void
    {
        $this->seed(DevelopmentDataSeeder::class);

        $this->assertSame(10, Category::count());
        $this->assertGreaterThanOrEqual(20, Book::count());
        $this->assertSame(15, User::members()->count());
        $this->assertSame(18, Borrowing::count());
        $this->assertGreaterThanOrEqual(1, Fine::count());
        $this->assertGreaterThanOrEqual(1, Payment::count());
        $this->assertGreaterThanOrEqual(1, User::members()->whereHas('attendances')->count());
    }

    public function test_seeder_members_have_the_member_role(): void
    {
        $this->seed(DevelopmentDataSeeder::class);

        $members = User::members()->get();

        $this->assertTrue($members->every(fn (User $member) => $member->hasRole('member')));
    }

    public function test_seeder_creates_overdue_borrowings_with_unpaid_fines(): void
    {
        $this->seed(DevelopmentDataSeeder::class);

        $this->assertGreaterThanOrEqual(1, Fine::unpaid()->count());
        $this->assertGreaterThanOrEqual(1, Borrowing::overdue()->count());
        $this->assertSame(0, Fine::query()->where('overdue_days', '<', 1)->count());
        $this->assertSame(0, Fine::query()->where('amount', '<', 0)->count());
    }

    public function test_database_seeder_skips_dev_data_outside_local_environment(): void
    {
        $this->seed();

        $this->assertSame(0, Category::count());
        $this->assertSame(0, User::count());
    }
}
