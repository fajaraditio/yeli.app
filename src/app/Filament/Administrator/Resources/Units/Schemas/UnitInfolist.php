<?php

namespace App\Filament\Administrator\Resources\Units\Schemas;

use App\Constants\UnitConstant;
use App\Constants\UnitLearningMaterialConstant;
use App\Models\Unit;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\DB;

class UnitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unit Information')
                    ->description('Basic information for this learning unit.')
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
                            ->placeholder('-'),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),

                Section::make('Learning Materials')
                    ->description('Summary of uploaded materials in this unit.')
                    ->schema([
                        TextEntry::make('learning_materials_summary')
                            ->hiddenLabel()
                            ->state(fn(Unit $record) => static::getMaterialTypeCounts($record))
                            ->badge()
                            ->icon(fn(string $state): Phosphor => match (true) {
                                str_contains($state, UnitLearningMaterialConstant::Type_Pdf) => Phosphor::FilePdf,
                                str_contains($state, UnitLearningMaterialConstant::Type_Ppt) => Phosphor::FilePpt,
                                str_contains($state, UnitLearningMaterialConstant::Type_Video) => Phosphor::FileVideo,
                                default => Phosphor::File,
                            })
                            ->color(fn(string $state): string => match (true) {
                                str_contains($state, UnitLearningMaterialConstant::Type_Pdf) => 'danger',
                                str_contains($state, UnitLearningMaterialConstant::Type_Ppt) => 'warning',
                                str_contains($state, UnitLearningMaterialConstant::Type_Video) => 'info',
                                default => 'gray',
                            })
                            ->placeholder('No materials uploaded yet'),
                    ])
                    ->columnSpanFull(),

                Section::make('Task Activities')
                    ->description('Task & Skillset activities configured for this unit.')
                    ->schema([
                        TextEntry::make('task_activities')
                            ->hiddenLabel()
                            ->state(fn(Unit $record) => static::getTaskActivityLabels($record))
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->icon(Phosphor::ListChecks)
                            ->placeholder('No task activities added yet'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function getMaterialTypeCounts(Unit $record): array
    {
        return $record->learning_materials()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->map(fn($total, $type) => "{$total} {$type}")
            ->values()
            ->toArray();
    }

    protected static function getTaskActivityLabels(Unit $record): array
    {
        return $record->task_skillsets()
            ->with('task_skillset')
            ->get()
            ->map(fn($item) => "{$item->task_skillset->task->name} - {$item->task_skillset->skillset_name}")
            ->toArray();
    }
}
