<?php

namespace App\Filament\Administrator\Resources\Blooms\Pages;

use App\Filament\Administrator\Resources\Blooms\BloomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBloom extends EditRecord
{
    protected static string $resource = BloomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
