<?php

namespace App\Filament\Administrator\Resources\Skillsets\Pages;

use App\Filament\Administrator\Resources\Skillsets\SkillsetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListSkillsets extends ListRecords
{
    protected static string $resource = SkillsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
