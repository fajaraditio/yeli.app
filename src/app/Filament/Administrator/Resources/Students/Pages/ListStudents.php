<?php

namespace App\Filament\Administrator\Resources\Students\Pages;

use App\Filament\Administrator\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'List of registered students';
    }
}
