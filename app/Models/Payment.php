<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['fine_id', 'user_id', 'order_id', 'transaction_id', 'provider', 'payment_type', 'amount', 'status', 'paid_at', 'raw_response'])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'raw_response' => 'array',
            'status' => PaymentStatus::class,
        ];
    }

    public function fine(): BelongsTo
    {
        return $this->belongsTo(Fine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Pending);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Paid);
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Failed);
    }
}
