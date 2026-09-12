<?php

namespace App\Filament\Administrator\Resources\Units\RelationManagers;

use App\Constants\UnitConstant;
use App\Models\TaskSkillset;
use App\Models\UnitTaskSkillset;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TaskSkillsetRelationManager extends RelationManager
{
    protected static string $relationship = 'task_skillsets';

    // protected static ?string $relatedResource = UnitResource::class;

    protected static ?string $title = 'Task Activity';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make(self::$title)
            ->badge($ownerRecord->task_skillsets()->count())
            ->badgeColor('info')
            ->badgeTooltip('The number of tasks created in this unit')
            ->icon(Phosphor::CheckSquareOffset);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task & Key Skill')
                    ->schema([
                        Select::make('task_skillset_id')
                            ->label('Task & Key Skill')
                            ->prefixIcon(Phosphor::Tag)
                            ->options(function (?Model $record, RelationManager $livewire): array {
                                $unitId = $livewire->getOwnerRecord()->getKey();

                                return static::getGroupedTaskSkillsetOptions($unitId, $record?->getKey());
                            })
                            ->searchable()
                            ->required(),
                    ])
                    ->columnSpanFull(),

                Section::make('Excerpt')
                    ->description('Optional. Leave blank if this activity has no reading excerpt (e.g. a post-task project).')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->placeholder('Example: Proponents argue that automated credit scoring removes human bias entirely...')
                            ->rows(4)
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

                Section::make('Questions')
                    ->description('Add one or more questions for this activity.')
                    ->schema([
                        Repeater::make('question')
                            ->hiddenLabel()
                            ->schema([
                                Textarea::make('question_text')
                                    ->label('Question')
                                    ->hiddenLabel()
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->addActionLabel('Add Question')
                            ->reorderable()
                            ->itemNumbers()
                            ->itemLabel('Question')
                            ->minItems(1)
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function getGroupedTaskSkillsetOptions(?int $unitId = null, ?int $ignoreRecordId = null): array
    {
        $usedTaskSkillsetIds = UnitTaskSkillset::query()
            ->when($unitId, fn($query) => $query->where('unit_id', $unitId))
            ->when($ignoreRecordId, fn($query) => $query->where('id', '!=', $ignoreRecordId))
            ->pluck('task_skillset_id');

        return TaskSkillset::query()
            ->with('task')
            ->whereNotIn('id', $usedTaskSkillsetIds)
            ->get()
            ->groupBy(fn(TaskSkillset $item): string => $item->task->name ?? 'Uncategorized')
            ->map(fn($group) => $group
                ->mapWithKeys(fn(TaskSkillset $item): array => [
                    $item->id => "{$item->task->name} - {$item->skillset_name}",
                ])
                ->toArray())
            ->toArray();
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(self::$title)
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->icon(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published ? Phosphor::Prohibit : Phosphor::Plus)
                    ->tooltip(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published ? 'You cannot add task activity while unit status is published' : '')
                    ->disabled(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published),
            ])
            ->reorderable('order_number')
            ->defaultGroup('task_skillset.task.name')
            ->columns([
                TextColumn::make('order_number')
                    ->sortable(),

                TextColumn::make('task_skillset.skillset_name')
                    ->label('Key Skill')
                    ->badge()
                    ->color(fn($record) => Color::hex($record->task_skillset?->skillset?->color)),

                TextColumn::make('excerpt')
                    ->label('Excerpt')
                    ->placeholder('No Excerpt'),

                TextColumn::make('question')
                    ->label('Questions')
                    ->state(fn($record): int => count($record->question ?? []))
                    ->suffix(' question(s)')
                    ->icon(Phosphor::ListChecks),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->icon(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published ? Phosphor::Prohibit : Phosphor::Pencil)
                    ->tooltip(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published ? 'You cannot edit task activity while unit status is published' : '')
                    ->disabled(fn() => $this->getOwnerRecord()->status === UnitConstant::Status_Published),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
