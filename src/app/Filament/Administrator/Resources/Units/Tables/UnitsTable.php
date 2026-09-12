<?php

namespace App\Filament\Administrator\Resources\Units\Tables;

use App\Constants\UnitConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Grid;
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

                    Grid::make()
                        ->schema([
                            TextColumn::make('bloom.name')
                                ->badge()
                                ->size(TextSize::Medium)
                                ->prefix('Bloom: ')
                                ->color(fn($record) => Color::hex($record->bloom->color ?? '#dddddd'))
                                ->icon(Phosphor::Intersect)
                                ->searchable()
                                ->columnSpan(1),

                            TextColumn::make('status')
                                ->weight('bold')
                                ->size(TextSize::Medium)
                                ->prefix('Status: ')
                                ->badge()
                                ->icon(Phosphor::Info)
                                ->color(fn($state) => $state ? UnitConstant::Status_Colors[$state] : 'gray')
                                ->columnSpan(2),
                        ])
                        ->columns(3),

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

                Action::make('publish')
                    ->label('Publish')
                    ->icon(Phosphor::PaperPlane)
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => UnitConstant::Status_Published]))
                    ->successNotificationTitle('Unit status has been successfully published')
                    ->failureNotificationTitle('Unit status has an error while publishing')
                    ->visible(fn($record) => $record->status === UnitConstant::Status_InReview),

                Action::make('inReview')
                    ->label(fn($record) => $record->status === UnitConstant::Status_Published ? 'Rollback to Review' : 'Make In-Review')
                    ->icon(Phosphor::Eyeglasses)
                    ->button()
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => UnitConstant::Status_InReview]))
                    ->successNotificationTitle('Unit status has been successfully updated')
                    ->failureNotificationTitle('Unit status has an error while updating')
                    ->visible(fn($record) => $record->status !== UnitConstant::Status_InReview),

                Action::make('draft')
                    ->label('Rollback to Draft')
                    ->icon(Phosphor::Archive)
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => UnitConstant::Status_Draft]))
                    ->successNotificationTitle('Unit status has been successfully rolled back to Draft')
                    ->failureNotificationTitle('Unit status has an error while rolling back to Draft')
                    ->visible(fn($record) => $record->status === UnitConstant::Status_InReview),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
