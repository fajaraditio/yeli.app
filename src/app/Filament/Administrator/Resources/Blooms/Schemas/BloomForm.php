<?php

namespace App\Filament\Administrator\Resources\Blooms\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BloomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->placeholder('Example: Analyze')
                    ->required()
                    ->columnSpanFull(),

                ColorPicker::make('color')
                    ->default('#dddddd')
                    ->columnSpanFull(),
            ]);
    }
}
