<?php

namespace App\Filament\Administrator\Resources\Units\RelationManagers;

use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TaskSkillsetRelationManager extends RelationManager
{
    protected static string $relationship = 'task_skillsets';

    // protected static ?string $relatedResource = UnitResource::class;

    protected static ?string $title = 'Task Creation';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make('Task Creation')
            ->badge($ownerRecord->task_skillsets()->count())
            ->badgeColor('info')
            ->badgeTooltip('The number of tasks created in this unit')
            ->icon(Phosphor::CheckSquareOffset);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
