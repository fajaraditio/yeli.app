<?php

namespace App\Filament\Administrator\Resources\Lecturers\Tables;

use App\Constants\UserConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LecturersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.avatar')
                    ->label('Avatar')
                    ->circular(),

                TextColumn::make('code')
                    ->label('Lecturer ID')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Lecturer Name')
                    ->description(fn($record) => $record->user->email)
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

                ActionGroup::make([
                    EditAction::make()
                        ->color('gray'),

                    Action::make('approve')
                        ->label('Approve')
                        ->icon(Phosphor::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Lecturer Account')
                        ->modalDescription('Are you sure you want to approve this lecturer account?')
                        ->action(function ($record) {
                            $record->user->update(['status' => UserConstant::Status_Pending]);
                        })
                        ->visible(fn($record) => $record->user?->status === UserConstant::Status_Pending),

                    Action::make('reject')
                        ->label('Reject')
                        ->icon(Phosphor::XCircle)
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Reject Lecturer Account')
                        ->modalDescription('Are you sure you want to reject this lecturer account?')
                        ->action(function ($record) {
                            $record->user->update(['status' => UserConstant::Status_Rejected]);
                        })
                        ->visible(fn($record) => $record->user?->status === UserConstant::Status_Pending),

                    Action::make('suspend')
                        ->label('Suspend')
                        ->icon(Phosphor::Prohibit)
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Suspend Lecturer Account')
                        ->modalDescription('Are you sure you want to suspend this lecturer account?')
                        ->action(function ($record) {
                            $record->user->update(['status' => UserConstant::Status_Suspended]);
                        })
                        ->visible(fn($record) => $record->user?->status === UserConstant::Status_Approved),

                    Action::make('unsuspend')
                        ->label('Unsuspend')
                        ->icon(Phosphor::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Unsuspend Lecturer Account')
                        ->modalDescription('Are you sure you want to unsuspend this lecturer account?')
                        ->action(function ($record) {
                            $record->user->update(['status' => UserConstant::Status_Approved]);
                        })
                        ->visible(fn($record) => $record->user?->status === UserConstant::Status_Suspended),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
