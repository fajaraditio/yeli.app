<?php

namespace App\Filament\Administrator\Resources\Blooms\Pages;

use App\Filament\Administrator\Resources\Blooms\BloomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListBlooms extends ListRecords
{
    protected static string $resource = BloomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::Medium),
        ];
    }
}
