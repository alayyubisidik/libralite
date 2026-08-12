<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;

#[UseFactory(UserFactory::class)]
class Member extends User
{
    /**
     * Members share the users table with admins (db.sql v2).
     */
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $builder->whereNotNull('member_code');
        });
    }
}
