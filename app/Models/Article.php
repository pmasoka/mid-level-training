<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'status',
        'published_at',
        'view_count',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'status' => ArticleStatus::class,
            'published_at' => 'datetime',
            'view_count' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function getSummaryAttribute(): string
    {
        return substr($this->body, 0, 150);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ArticleStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', ArticleStatus::Draft);
    }

    public function scopePopular(Builder $query, int $minimumViews = 100): Builder
    {
        return $query->where('view_count', '>=', $minimumViews);
    }
}