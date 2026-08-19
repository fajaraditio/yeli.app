<?php

namespace App\Filament\Administrator\Resources\Units\Tables;

use App\Constants\UnitConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->weight('bold')
                        ->size(TextSize::Large)
                        ->searchable(),

                    TextColumn::make('bloom.name')
                        ->badge()
                        ->color(fn($record) => Color::hex($record->bloom->color ?? '#dddddd'))
                        ->icon(Phosphor::Intersect)
                        ->searchable(),

                    TextColumn::make('created_at')
                        ->label('Created at')
                        ->dateTime('l, d-M-Y')
                        ->sortable()
                        ->color('gray')
                        ->size(TextSize::Small)
                        ->toggleable(isToggledHiddenByDefault: true),

                ])
                    ->space(2),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->button()
                    ->color('gray')
                    ->outlined(),

                EditAction::make()
                    ->button()
                    ->outlined(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
