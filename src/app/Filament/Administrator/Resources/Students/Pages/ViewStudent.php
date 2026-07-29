<?php

namespace App\Filament\Administrator\Resources\Students\Pages;

use App\Filament\Administrator\Resources\Students\StudentResource;
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
        ];
    }

    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return str(parent::getHeading())->title();
    }
}
