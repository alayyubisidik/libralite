<?php

namespace App\Models;

use App\Enums\BorrowingStatus;
use Database\Factories\BorrowingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'book_id', 'processed_by', 'borrow_code', 'borrow_date', 'due_date', 'returned_at', 'status'])]
class Borrowing extends Model
{
    /** @use HasFactory<BorrowingFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'due_date' => 'date',
            'returned_at' => 'datetime',
            'status' => BorrowingStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '!=', BorrowingStatus::Returned);
    }

    public function scopeBorrowed(Builder $query): Builder
    {
        return $query->where('status', BorrowingStatus::Borrowed);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', BorrowingStatus::Overdue);
    }

    public function scopeReturned(Builder $query): Builder
    {
        return $query->where('status', BorrowingStatus::Returned);
    }

    public function isOverdue(): bool
    {
        return $this->status === BorrowingStatus::Borrowed
            && $this->due_date?->isPast();
    }
}
