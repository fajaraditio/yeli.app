<?php

namespace App\Filament\Administrator\Resources\Tasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Sort Number')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('name')
                    ->description(fn($record): string => $record->description ?? '-')
                    ->searchable(),

                TextColumn::make('task_skillsets.skillset_name')
                    ->color(fn($record) => Color::hex($record->task_skillsets[0]->skillset_color))
                    ->badge(),

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
            ->defaultSort('order_number', 'asc')
            ->reorderable('order_number')
            ->recordActions([
                EditAction::make()
                    ->modalWidth(Width::Large),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
