<?php

namespace App\Filament\Administrator\Resources\Lecturers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LecturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('code')
                    ->default(null),
            ]);
    }
}
