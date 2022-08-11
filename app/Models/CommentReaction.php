<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CommentReaction extends Model
{
    use HasFactory;

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
