<?php

namespace App\Filament\Administrator\Resources\Classrooms;

use App\Filament\Administrator\Resources\Classrooms\Pages\ListClassrooms;
use App\Filament\Administrator\Resources\Classrooms\Schemas\ClassroomForm;
use App\Filament\Administrator\Resources\Classrooms\Tables\ClassroomsTable;
use App\Models\Classroom;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::Chalkboard;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static null|string $modelLabel = 'Class Room';

    protected static ?string $recordTitleAttribute = 'name';

    protected static null|int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ClassroomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassroomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClassrooms::route('/'),
        ];
    }
}
