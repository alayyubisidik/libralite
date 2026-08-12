<?php

namespace Tests\Feature;

use App\Enums\BookStatus;
use App\Enums\BorrowingStatus;
use App\Enums\FineStatus;
use App\Enums\MemberStatus;
use App\Enums\PaymentStatus;
use App\Models\Attendance;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Member;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_is_generated_from_name(): void
    {
        $category = Category::create([
            'name' => 'Sains & Teknologi',
        ]);

        $this->assertSame('sains-teknologi', $category->slug);
    }

    public function test_category_slug_is_unique_when_slug_would_collide(): void
    {
        Category::create(['name' => 'Sains & Teknologi']);
        $duplicate = Category::create(['name' => 'Sains Teknologi']);

        $this->assertCount(2, Category::all());
        $this->assertNotSame('sains-teknologi', $duplicate->slug);
        $this->assertStringStartsWith('sains-teknologi', $duplicate->slug);
    }

    public function test_member_query_only_returns_accounts_with_member_code(): void
    {
        User::factory()->admin()->create();
        User::factory()->count(3)->member()->create();

        $this->assertCount(4, User::all());
        $this->assertCount(3, Member::all());
    }

    public function test_user_member_scope_filters_member_accounts(): void
    {
        User::factory()->admin()->create();
        User::factory()->member()->create();

        $this->assertCount(1, User::members()->get());
        $this->assertTrue(User::members()->first()->isMember());
    }

    public function test_member_status_is_casted_to_enum(): void
    {
        $member = User::factory()->member()->create();

        $this->assertInstanceOf(MemberStatus::class, $member->member_status);
        $this->assertSame(MemberStatus::Active, $member->member_status);
    }

    public function test_admin_helper_checks_assigned_role(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->admin()->create();
        $admin->assignRole('admin');

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isMember());
    }

    public function test_book_belongs_to_category_and_category_has_many_books(): void
    {
        $category = Category::factory()->create();
        $book = Book::factory()->for($category)->create();

        $this->assertTrue($book->category->is($category));
        $this->assertTrue($category->books->contains($book));
    }

    public function test_book_status_is_casted_to_enum(): void
    {
        $book = Book::factory()->inactive()->create();

        $this->assertSame(BookStatus::Inactive, $book->status);
    }

    public function test_borrowing_fine_and_payment_relationships(): void
    {
        $member = Member::factory()->member()->create();
        $book = Book::factory()->create();
        $borrowing = Borrowing::factory()->for($member, 'user')->for($book)->create();
        $fine = Fine::factory()->create(['borrowing_id' => $borrowing->id]);
        $payment = Payment::factory()->create([
            'fine_id' => $fine->id,
            'user_id' => $member->id,
            'amount' => $fine->amount,
            'status' => PaymentStatus::Paid,
        ]);

        $this->assertTrue($borrowing->user->is($member));
        $this->assertTrue($borrowing->book->is($book));
        $this->assertTrue($borrowing->fine->is($fine));
        $this->assertTrue($fine->borrowing->is($borrowing));
        $this->assertTrue($payment->fine->is($fine));
        $this->assertTrue($payment->user->is($member));
        $this->assertTrue($member->borrowings->contains($borrowing));
        $this->assertTrue($member->payments->contains($payment));
        $this->assertTrue($book->borrowings->contains($borrowing));
    }

    public function test_borrowing_status_enum_cast_and_scopes(): void
    {
        Borrowing::factory()->create();
        Borrowing::factory()->overdue()->create();
        $returned = Borrowing::factory()->returned()->create();

        $this->assertSame(BorrowingStatus::Returned, $returned->status);
        $this->assertCount(2, Borrowing::active()->get());
        $this->assertCount(1, Borrowing::borrowed()->get());
        $this->assertCount(1, Borrowing::overdue()->get());
        $this->assertCount(1, Borrowing::returned()->get());
    }

    public function test_book_available_stock_accounts_for_active_borrowings(): void
    {
        $book = Book::factory()->create(['stock' => 5]);
        Borrowing::factory()->for($book)->create();

        $this->assertSame(4, $book->availableStock());
    }

    public function test_fine_and_payment_status_casts_and_scopes(): void
    {
        Fine::factory()->create();
        Fine::factory()->paid()->create();
        Fine::factory()->waived()->create();

        $this->assertCount(1, Fine::unpaid()->get());
        $this->assertCount(1, Fine::paid()->get());
        $this->assertCount(1, Fine::waived()->get());

        $fine = Fine::factory()->paid()->create();
        $this->assertSame('2000.00', $fine->rate_per_day);
        $this->assertSame(FineStatus::Paid, $fine->status);
    }

    public function test_payment_status_is_casted_to_enum(): void
    {
        $payment = Payment::factory()->paid()->create();

        $this->assertSame(PaymentStatus::Paid, $payment->status);
        $this->assertNotNull($payment->paid_at);
    }

    public function test_attendance_belongs_to_user(): void
    {
        $member = User::factory()->member()->create();
        $attendance = Attendance::factory()->for($member)->create();

        $this->assertTrue($attendance->user->is($member));
    }
}
