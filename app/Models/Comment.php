<?php

namespace App\Models;

use App\Documentation\Models\PathInfo;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperComment
 */
final class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'reactions_counter' => CommentReactionsCounter::class,
    ];

    public function fromPathInfo(PathInfo $pathInfo): static
    {
        $this->locale = $pathInfo->locale;
        $this->doc = $pathInfo->doc;
        $this->version = $pathInfo->version;
        $this->page = $pathInfo->page;

        return $this;
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function scopeWhereApproved(Builder $query, bool $approved = true): Builder
    {
        return $query->where('is_approved', $approved);
    }

    public function scopeByPathInfo(Builder $query, PathInfo $pathInfo): Builder
    {
        return $query
            ->where('locale', $pathInfo->locale->value)
            ->where('doc', $pathInfo->doc)
            ->where('page', $pathInfo->page);
    }
}
