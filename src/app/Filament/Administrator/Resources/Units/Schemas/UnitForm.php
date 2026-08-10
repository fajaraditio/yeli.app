<?php

namespace App\Filament\Administrator\Resources\Units\Schemas;

use App\Constants\UnitConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unit Information')
                    ->description('Fill in the basic information for this learning unit.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Unit Title')
                            ->placeholder('Example: Ethical Dilemmas in Technology')
                            ->prefixIcon(Phosphor::BookOpenText)
                            ->required(),

                        Select::make('bloom_level')
                            ->label('Bloom Level')
                            ->prefixIcon(Phosphor::GraduationCap)
                            ->options(array_combine(
                                UnitConstant::BloomLevel_Enums,
                                UnitConstant::BloomLevel_Enums
                            ))
                            ->native(false),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Short summary of what students will learn in this unit.')
                            ->default(null)
                            ->rows(3)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Status')
                            ->prefixIcon(Phosphor::CheckCircle)
                            ->options(array_combine(
                                UnitConstant::Status_Enums,
                                UnitConstant::Status_Enums
                            ))
                            ->default(UnitConstant::Status_Draft)
                            ->native(false)
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
