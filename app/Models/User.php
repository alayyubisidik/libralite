<?php

namespace App\Models;

use App\Enums\MemberStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'member_code', 'phone', 'address', 'date_of_birth', 'member_status', 'joined_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, InteractsWithMedia, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'joined_at' => 'date',
            'member_status' => MemberStatus::class,
        ];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'user_id');
    }

    public function processedBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'processed_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')->singleFile();
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->whereNotNull('member_code');
    }

    public function scopeActiveMembers(Builder $query): Builder
    {
        return $query->members()->where('member_status', MemberStatus::Active);
    }

    public function isMember(): bool
    {
        return $this->member_code !== null;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
