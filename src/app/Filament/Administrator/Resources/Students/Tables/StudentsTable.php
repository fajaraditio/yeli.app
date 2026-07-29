<?php

namespace App\Filament\Administrator\Resources\Students\Tables;

use App\Constants\UserConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Student ID')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Student Name')
                    ->description(fn($record) => $record->user->email)
                    ->numeric()
                    ->sortable(),

                TextColumn::make('classroom_name')
                    ->label('Classroom Name')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('user.status')
                    ->label('Account Status')
                    ->badge()
                    ->color(fn(?string $state): string => UserConstant::Status_Colors[$state] ?? 'gray')
                    ->icon(fn(?string $state): Phosphor|string|null => UserConstant::Status_Icons[$state] ?? null)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
