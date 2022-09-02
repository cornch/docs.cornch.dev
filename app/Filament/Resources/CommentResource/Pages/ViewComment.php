<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

final class ViewComment extends ViewRecord
{
    protected static string $resource = CommentResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('approve')
                ->action(function () {
                    $this->record->is_approved = true;
                    $this->record->save();
                })
                ->requiresConfirmation(),
        ];
    }
}
