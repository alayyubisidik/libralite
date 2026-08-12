<?php

namespace App\Models;

use App\Enums\FineStatus;
use Database\Factories\FineFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['borrowing_id', 'rate_per_day', 'overdue_days', 'amount', 'status'])]
class Fine extends Model
{
    /** @use HasFactory<FineFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rate_per_day' => 'decimal:2',
            'overdue_days' => 'integer',
            'amount' => 'decimal:2',
            'status' => FineStatus::class,
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('status', FineStatus::Unpaid);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', FineStatus::Paid);
    }

    public function scopeWaived(Builder $query): Builder
    {
        return $query->where('status', FineStatus::Waived);
    }
}
