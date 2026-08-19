<?php

namespace App\Filament\Administrator\Resources\Skillsets\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkillsetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Key Skill')
                    ->disabled()
                    ->required()
                    ->columnSpanFull(),

                ColorPicker::make('color')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
