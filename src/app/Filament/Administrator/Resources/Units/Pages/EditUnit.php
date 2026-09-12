<?php

namespace App\Filament\Administrator\Resources\Units\Pages;

use App\Constants\UnitConstant;
use App\Filament\Administrator\Resources\Units\UnitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditUnit extends EditRecord
{
    protected static string $resource = UnitResource::class;

    #[Override]
    public function getRelationManagers(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
