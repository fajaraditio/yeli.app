<?php

namespace App\Filament\Administrator\Resources\Units\Schemas;

use App\Constants\UnitConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
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

                        TextEntry::make('bloom.name')
                            ->label('Bloom')
                            ->badge()
                            ->color(fn($record) => Color::hex($record->bloom->color))
                            ->icon(Phosphor::Intersect),


                        TextEntry::make('status')
                            ->label('Status')
                            ->size(TextSize::Medium)
                            ->badge()
                            ->icon(Phosphor::CheckCircle)
                            ->color(fn($state) => $state ? UnitConstant::Status_Colors[$state] : 'gray'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
