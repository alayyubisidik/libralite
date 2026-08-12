<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Expired = 'expired';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Paid => 'Dibayar',
            self::Failed => 'Gagal',
            self::Expired => 'Kadaluarsa',
            self::Cancelled => 'Dibatalkan',
        };
    }
}
