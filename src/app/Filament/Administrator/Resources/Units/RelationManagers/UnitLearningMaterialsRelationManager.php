<?php

namespace App\Filament\Administrator\Resources\Units\RelationManagers;

use App\Constants\UnitLearningMaterialConstant;
use App\Filament\Administrator\Resources\Units\UnitResource;
use App\Models\UnitLearningMaterial;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Override;

class UnitLearningMaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'learning_materials';

    // protected static ?string $relatedResource = UnitResource::class;

    protected static ?string $title = 'Learning Material';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
    {
        return Tab::make('Learning Material')
            ->badge($ownerRecord->learning_materials()->count())
            ->badgeColor('info')
            ->badgeTooltip('The number of learning materials in this unit')
            ->icon(Phosphor::Play);
    }

    #[Override]
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Material Information')
                    ->schema([
                        TextEntry::make('title')
                            ->icon(fn(UnitLearningMaterial $record): Phosphor => match ($record->type) {
                                UnitLearningMaterialConstant::Type_Pdf => Phosphor::FilePdf,
                                UnitLearningMaterialConstant::Type_Ppt => Phosphor::FilePpt,
                                UnitLearningMaterialConstant::Type_Video => Phosphor::FileVideo,
                                default => Phosphor::File,
                            })
                            ->iconColor(fn(UnitLearningMaterial $record): string => match ($record->type) {
                                UnitLearningMaterialConstant::Type_Pdf => 'danger',
                                UnitLearningMaterialConstant::Type_Ppt => 'warning',
                                UnitLearningMaterialConstant::Type_Video => 'info',
                                default => 'gray',
                            }),

                        TextEntry::make('file_path')
                            ->label('File Name')
                            ->formatStateUsing(fn(string $state): string => basename($state))
                            ->icon(Phosphor::Paperclip)
                            ->extraAttributes(['class' => 'hover:underline decoration-dotted'])
                            ->url(fn(UnitLearningMaterial $record): string => Storage::disk('public')->url($record->file_path))
                            ->openUrlInNewTab()
                            ->color('primary')
                            ->weight('bold'),

                        ImageEntry::make('file_path')
                            ->label('Preview')
                            ->disk('public')
                            ->visible(fn(UnitLearningMaterial $record): bool => in_array(
                                strtolower(pathinfo($record->file_path, PATHINFO_EXTENSION)),
                                ['jpg', 'jpeg', 'png', 'webp']
                            ))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Learning Material')
                    ->description('Upload a PDF, video, or PowerPoint file for this unit stage.')
                    ->schema([
                        Hidden::make('unit_id')
                            ->default($this->getOwnerRecord()->id)
                            ->required(),

                        TextInput::make('title')
                            ->label('Material Title')
                            ->placeholder('Example: Reading — The Algorithm in the Room')
                            ->prefixIcon(Phosphor::TextAa)
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('file_path')
                            ->label('File')
                            ->disk('public')
                            ->directory('unit-learning-materials')
                            ->acceptedFileTypes(UnitLearningMaterialConstant::Accepted_Mime_Types)
                            ->maxSize(102400) // 100 MB
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if (! $state instanceof UploadedFile) {
                                    return;
                                }

                                $extension = strtolower($state->getClientOriginalExtension());

                                $set('type', UnitLearningMaterialConstant::Extension_Map[$extension] ?? null);
                            })
                            ->required()
                            ->columnSpanFull(),

                        Select::make('type')
                            ->label('Detected Type')
                            ->options(array_combine(UnitLearningMaterialConstant::Type_Enums, UnitLearningMaterialConstant::Type_Enums))
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Automatically detected from the uploaded file — not editable.')
                            ->prefixIcon(Phosphor::FileText),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('New Learning Material'),
            ])
            ->description('Learning materials are resources that support the learning process within a unit. 
                They can include documents, presentations, videos, and other educational content that enhance the understanding of the subject matter.')
            ->reorderable('order_number')
            ->columns([
                TextColumn::make('order_number')
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('type')
                    ->badge()
                    ->icon(fn(string $state): Phosphor => match ($state) {
                        UnitLearningMaterialConstant::Type_Pdf => Phosphor::FilePdf,
                        UnitLearningMaterialConstant::Type_Ppt => Phosphor::FilePpt,
                        UnitLearningMaterialConstant::Type_Video => Phosphor::FileVideo,
                        default => Phosphor::File,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        UnitLearningMaterialConstant::Type_Pdf => 'danger',
                        UnitLearningMaterialConstant::Type_Ppt => 'warning',
                        UnitLearningMaterialConstant::Type_Video => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(array_combine(UnitLearningMaterialConstant::Type_Enums, UnitLearningMaterialConstant::Type_Enums))
                    ->native(false),
            ], layout: FiltersLayout::AboveContent)
            ->deferFilters(false)
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('View File')
                    ->extraModalFooterActions([
                        DeleteAction::make(),
                    ])
                    ->visible(fn($record) => $record->type === UnitLearningMaterialConstant::Type_Ppt),

                MediaAction::make('preview')
                    ->label('Preview')
                    ->icon(Phosphor::Play)
                    ->media(fn($record) => asset('storage/' . $record->file_path))
                    ->autoplay(fn($record, $mediaType) => $mediaType === 'video')
                    ->extraModalFooterActions([
                        DeleteAction::make(),
                    ])
                    ->hidden(fn($record) => $record->type === UnitLearningMaterialConstant::Type_Ppt),

                DeleteAction::make(),
            ]);
    }
}
