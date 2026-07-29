<?php

namespace App\Filament\Administrator\Resources\Lecturers;

use App\Filament\Administrator\Resources\Lecturers\Pages\CreateLecturer;
use App\Filament\Administrator\Resources\Lecturers\Pages\EditLecturer;
use App\Filament\Administrator\Resources\Lecturers\Pages\ListLecturers;
use App\Filament\Administrator\Resources\Lecturers\Pages\ViewLecturer;
use App\Filament\Administrator\Resources\Lecturers\Schemas\LecturerForm;
use App\Filament\Administrator\Resources\Lecturers\Schemas\LecturerInfolist;
use App\Filament\Administrator\Resources\Lecturers\Tables\LecturersTable;
use App\Models\Lecturer;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LecturerResource extends Resource
{
    protected static ?string $model = Lecturer::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::ChalkboardTeacher;

    protected static string|UnitEnum|null $navigationGroup = 'Users';

    protected static string|null $modelLabel = 'Lecturer';

    protected static ?string $recordTitleAttribute = 'user.name';

    public static function form(Schema $schema): Schema
    {
        return LecturerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LecturerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LecturersTable::configure($table);
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
            'index' => ListLecturers::route('/'),
            'create' => CreateLecturer::route('/create'),
            'view' => ViewLecturer::route('/{record}'),
            'edit' => EditLecturer::route('/{record}/edit'),
        ];
    }
}
