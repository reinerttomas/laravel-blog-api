<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PostBuilder;
use App\Enums\PostStatus;
use App\Observers\PostObserver;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(PostObserver::class)]
final class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'likes' => 0,
        'dislikes' => 0,
        'status' => PostStatus::Draft,
    ];

    protected $guarded = ['id'];

    /**
     * @return array<string, mixed>
     */
    protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'immutable_datetime',
        'archived_at' => 'immutable_datetime',
    ];

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function evaluateStatus(): void
    {
        if ($this->status->isDraft()) {
            $this->published_at = null;
            $this->archived_at = null;
        }

        if ($this->status->isPublished()) {
            $this->published_at = CarbonImmutable::now();
            $this->archived_at = null;
        }

        if ($this->status->isArchived()) {
            $this->archived_at = CarbonImmutable::now();
        }
    }
}
