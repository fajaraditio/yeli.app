<?php

namespace App\Filament\Administrator\Resources\Units\Pages;

use App\Filament\Administrator\Resources\Units\UnitResource;
use Filafly\Icons\Phosphor\Enums\Phosphor;
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
            EditAction::make(),
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
