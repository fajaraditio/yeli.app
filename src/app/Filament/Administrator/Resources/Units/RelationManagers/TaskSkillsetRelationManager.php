<?php

namespace App\Filament\Administrator\Resources\Units\RelationManagers;

use App\Models\TaskSkillset;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
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
                Section::make('Task & Skillset')
                    ->schema([
                        Select::make('task_skillset_id')
                            ->label('Task & Skillset')
                            ->prefixIcon(Phosphor::Tag)
                            ->options(fn() => static::getGroupedTaskSkillsetOptions())
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

    protected static function getGroupedTaskSkillsetOptions(): array
    {
        return TaskSkillset::query()
            ->with('task')
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
                    ->slideOver(),
            ])
            ->reorderable('order_number')
            ->columns([
                TextColumn::make('order_number')
                    ->label('#')
                    ->sortable(),

                TextColumn::make('taskSkillset.task.name')
                    ->label('Task')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('taskSkillset.skillset_name')
                    ->label('Skillset')
                    ->badge()
                    ->color(fn($record) => $record->taskSkillset?->skillset_color ?? 'gray'),

                TextColumn::make('excerpt')
                    ->label('Excerpt')
                    ->limit(50)
                    ->placeholder('— no excerpt —')
                    ->color('gray'),

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
                    ->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
