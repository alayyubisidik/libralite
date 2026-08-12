<?php

namespace App\Models;

use App\Enums\BookStatus;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Fillable(['category_id', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'stock', 'description', 'status'])]
class Book extends Model implements HasMedia
{
    /** @use HasFactory<BookFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'stock' => 'integer',
            'status' => BookStatus::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('book_cover')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(320)
            ->height(440);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', BookStatus::Active);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', BookStatus::Inactive);
    }

    public function availableStock(): int
    {
        return $this->stock - $this->borrowings()->active()->count();
    }
}
