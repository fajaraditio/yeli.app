<?php

namespace App\Filament\Administrator\Resources\Tasks\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled()
                    ->columnSpanFull(),

                TextInput::make('description')
                    ->placeholder('Example: A short authentic cose that triggers interpretotion before the core input.')
                    ->columnSpanFull(),

                CheckboxList::make('skillsets')
                    ->relationship(titleAttribute: 'name')
                    ->columnSpanFull(),
            ]);
    }
}
