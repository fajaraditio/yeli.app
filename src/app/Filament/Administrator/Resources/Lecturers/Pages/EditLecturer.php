<?php

namespace App\Filament\Administrator\Resources\Lecturers\Pages;

use App\Filament\Administrator\Resources\Lecturers\LecturerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLecturer extends EditRecord
{
    protected static string $resource = LecturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
