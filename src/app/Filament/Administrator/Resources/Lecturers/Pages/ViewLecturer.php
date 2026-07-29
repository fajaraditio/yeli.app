<?php

namespace App\Filament\Administrator\Resources\Lecturers\Pages;

use App\Filament\Administrator\Resources\Lecturers\LecturerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLecturer extends ViewRecord
{
    protected static string $resource = LecturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
