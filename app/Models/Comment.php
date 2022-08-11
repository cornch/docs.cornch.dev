<?php

namespace App\Models;

use App\Documentation\Models\Page;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'reactions_count' => CommentReactionsCount::class,
    ];

    public function reactions(): HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function scopeWhereApproved(Builder $query, bool $approved = true)
    {
        return $query->where('is_approved', $approved);
    }
}
