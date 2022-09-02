<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

final class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('locale'),
                Forms\Components\TextInput::make('doc'),
                Forms\Components\TextInput::make('version'),
                Forms\Components\TextInput::make('page'),
                Forms\Components\TextInput::make('commenter_fingerprint'),
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('delete_password'),
                Forms\Components\Textarea::make('content'),
                Forms\Components\Checkbox::make('is_approved'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doc'),
                Tables\Columns\TextColumn::make('version'),
                Tables\Columns\TextColumn::make('page'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\BooleanColumn::make('is_approved'),
            ])
            ->filters([
                Tables\Filters\Filter::make('approved')
                    ->query(fn (Builder $query) => $query->ofApproved()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'view' => Pages\ViewComment::route('/{record}/view'),
        ];
    }
}
