<?php

namespace App\Filament\Administrator\Resources\Students\Pages;

use App\Filament\Administrator\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
