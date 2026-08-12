<?php

namespace App\Enums;

enum BorrowingStatus: string
{
    case Borrowed = 'borrowed';
    case Returned = 'returned';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::Borrowed => 'Dipinjam',
            self::Returned => 'Dikembalikan',
            self::Overdue => 'Terlambat',
        };
    }
}
