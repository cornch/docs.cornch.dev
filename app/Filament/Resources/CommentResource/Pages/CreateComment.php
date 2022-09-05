<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;
}