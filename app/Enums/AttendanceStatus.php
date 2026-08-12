<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case Present = 'present';

    public function label(): string
    {
        return match ($this) {
            self::Present => 'Hadir',
        };
    }
}
