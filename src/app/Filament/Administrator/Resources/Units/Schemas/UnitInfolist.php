<?php

namespace App\Filament\Administrator\Resources\Units\Schemas;

use App\Constants\UnitConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UnitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unit Information')
                    ->description('Fill in the basic information for this learning unit.')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Unit Title')
                            ->icon(Phosphor::BookOpenText),

                        TextEntry::make('bloom_level')
                            ->label('Bloom Level')
                            ->icon(Phosphor::GraduationCap),

                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('status')
                            ->label('Status')
                            ->size(TextSize::Medium)
                            ->badge()
                            ->icon(Phosphor::CheckCircle)
                            ->color(fn($state) => $state ? UnitConstant::Status_Colors[$state] : 'gray'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
