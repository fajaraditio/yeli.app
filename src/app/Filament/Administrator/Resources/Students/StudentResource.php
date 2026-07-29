<?php

namespace App\Filament\Administrator\Resources\Students;

use App\Filament\Administrator\Resources\Students\Pages\CreateStudent;
use App\Filament\Administrator\Resources\Students\Pages\EditStudent;
use App\Filament\Administrator\Resources\Students\Pages\ListStudents;
use App\Filament\Administrator\Resources\Students\Pages\ViewStudent;
use App\Filament\Administrator\Resources\Students\Schemas\StudentForm;
use App\Filament\Administrator\Resources\Students\Schemas\StudentInfolist;
use App\Filament\Administrator\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::Student;

    protected static string|UnitEnum|null $navigationGroup = 'Users';

    protected static ?string $recordTitleAttribute = 'user.name';

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
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
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'view' => ViewStudent::route('/{record}'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
