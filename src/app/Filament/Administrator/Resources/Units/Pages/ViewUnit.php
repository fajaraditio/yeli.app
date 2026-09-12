<?php

namespace App\Filament\Administrator\Resources\Units\Pages;

use App\Constants\UnitConstant;
use App\Filament\Administrator\Resources\Units\UnitResource;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\Enums\ContentTabPosition;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class ViewUnit extends ViewRecord
{
    protected static string $resource = UnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->outlined()
                ->icon(fn($record) => $record->status === UnitConstant::Status_Published ? Phosphor::Prohibit : Phosphor::Pencil)
                ->color(fn($record) => $record->status === UnitConstant::Status_Published ? 'gray' : 'success')
                ->disabled(fn($record) => $record->status === UnitConstant::Status_Published)
                ->tooltip(fn($record) => $record->status === UnitConstant::Status_Published ? 'Rollback status to review or draft to edit' : ''),

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
        ];
    }

    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return $this->record->title;
    }

    #[Override]
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    #[Override]
    public function getContentTabComponent(): Tab
    {
        return parent::getContentTabComponent()
            ->label('Unit Information')
            ->icon(Phosphor::Info);
    }

    #[Override]
    public function getContentTabPosition(): ?ContentTabPosition
    {
        return ContentTabPosition::Before;
    }
}
