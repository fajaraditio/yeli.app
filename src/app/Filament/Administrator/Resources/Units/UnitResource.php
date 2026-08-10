<?php

namespace App\Filament\Administrator\Resources\Units;

use App\Filament\Administrator\Resources\Units\Pages\CreateUnit;
use App\Filament\Administrator\Resources\Units\Pages\EditUnit;
use App\Filament\Administrator\Resources\Units\Pages\ListUnits;
use App\Filament\Administrator\Resources\Units\Pages\ViewUnit;
use App\Filament\Administrator\Resources\Units\Schemas\UnitForm;
use App\Filament\Administrator\Resources\Units\Schemas\UnitInfolist;
use App\Filament\Administrator\Resources\Units\Tables\UnitsTable;
use App\Models\Unit;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::BookOpenText;

    protected static null|string $modelLabel = 'Learning Unit';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return UnitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitsTable::configure($table);
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
            'index' => ListUnits::route('/'),
            'create' => CreateUnit::route('/create'),
            'view' => ViewUnit::route('/{record}'),
            'edit' => EditUnit::route('/{record}/edit'),
        ];
    }
}
