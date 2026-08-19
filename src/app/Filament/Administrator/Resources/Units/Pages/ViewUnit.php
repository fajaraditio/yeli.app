<?php

namespace App\Filament\Administrator\Resources\Units\Pages;

use App\Filament\Administrator\Resources\Units\UnitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
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
}
