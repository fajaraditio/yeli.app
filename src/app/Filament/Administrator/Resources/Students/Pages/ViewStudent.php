<?php

namespace App\Filament\Administrator\Resources\Students\Pages;

use App\Constants\UserConstant;
use App\Filament\Administrator\Resources\Students\StudentResource;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            Action::make('approve')
                ->label('Approve')
                ->icon(Phosphor::CheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Student Account')
                ->modalDescription('Are you sure you want to approve this student account?')
                ->action(function ($record) {
                    $record->user->update(['status' => UserConstant::Status_Approved]);
                })
                ->visible(fn($record) => $record->user?->status === UserConstant::Status_Pending),

            Action::make('reject')
                ->label('Reject')
                ->icon(Phosphor::XCircle)
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reject Student Account')
                ->modalDescription('Are you sure you want to reject this student account?')
                ->action(function ($record) {
                    $record->user->update(['status' => UserConstant::Status_Rejected]);
                })
                ->visible(fn($record) => $record->user?->status === UserConstant::Status_Pending),

            Action::make('suspend')
                ->label('Suspend')
                ->icon(Phosphor::Prohibit)
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Suspend Student Account')
                ->modalDescription('Are you sure you want to suspend this student account?')
                ->action(function ($record) {
                    $record->user->update(['status' => UserConstant::Status_Suspended]);
                })
                ->visible(fn($record) => $record->user?->status === UserConstant::Status_Approved),

            Action::make('unsuspend')
                ->label('Unsuspend')
                ->icon(Phosphor::CheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Unsuspend Student Account')
                ->modalDescription('Are you sure you want to unsuspend this student account?')
                ->action(function ($record) {
                    $record->user->update(['status' => UserConstant::Status_Approved]);
                })
                ->visible(fn($record) => $record->user?->status === UserConstant::Status_Suspended),
        ];
    }

    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return str(parent::getHeading())->title();
    }
}
