<?php

namespace App\Filament\Administrator\Resources\Units\RelationManagers;

use App\Constants\UnitLearningMaterialConstant;
use App\Filament\Administrator\Resources\Units\UnitResource;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Tables\Table;
use Illuminate\Http\UploadedFile;

class UnitLearningMaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'learning_materials';

    protected static ?string $relatedResource = UnitResource::class;

    protected static ?string $title = 'Learning Material';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->description('Learning materials are resources that support the learning process within a unit. They can include documents, presentations, videos, and other educational content that enhance the understanding of the subject matter.')
            ->headerActions([
                CreateAction::make()
                    ->schema([
                        Section::make('Learning Material')
                            ->description('Upload a PDF, video, or PowerPoint file for this unit stage.')
                            ->schema([
                                Select::make('unit_id')
                                    ->label('Unit Stage')
                                    ->relationship('unit', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->prefixIcon(Phosphor::Stack)
                                    ->required(),

                                TextInput::make('title')
                                    ->label('Material Title')
                                    ->placeholder('Example: Reading — The Algorithm in the Room')
                                    ->prefixIcon(Phosphor::TextAa)
                                    ->required(),

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

                                TextInput::make('order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(0)
                                    ->prefixIcon(Phosphor::SortAscending),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
