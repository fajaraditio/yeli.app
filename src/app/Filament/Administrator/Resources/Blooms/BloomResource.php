<?php

namespace App\Filament\Administrator\Resources\Blooms;

use App\Filament\Administrator\Resources\Blooms\Pages\CreateBloom;
use App\Filament\Administrator\Resources\Blooms\Pages\EditBloom;
use App\Filament\Administrator\Resources\Blooms\Pages\ListBlooms;
use App\Filament\Administrator\Resources\Blooms\Schemas\BloomForm;
use App\Filament\Administrator\Resources\Blooms\Tables\BloomsTable;
use App\Models\Bloom;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BloomResource extends Resource
{
    protected static ?string $model = Bloom::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::Intersect;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static null|string $modelLabel = 'Bloom Level';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BloomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BloomsTable::configure($table);
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
            'index' => ListBlooms::route('/'),
        ];
    }
}
