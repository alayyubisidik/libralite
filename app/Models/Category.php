<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Cviebrock\EloquentSluggable\Sluggable;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'status'])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
        ];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::Active);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', CategoryStatus::Inactive);
    }
}
