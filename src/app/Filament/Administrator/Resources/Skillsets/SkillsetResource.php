<?php

namespace App\Filament\Administrator\Resources\Skillsets;

use App\Filament\Administrator\Resources\Skillsets\Pages\CreateSkillset;
use App\Filament\Administrator\Resources\Skillsets\Pages\EditSkillset;
use App\Filament\Administrator\Resources\Skillsets\Pages\ListSkillsets;
use App\Filament\Administrator\Resources\Skillsets\Schemas\SkillsetForm;
use App\Filament\Administrator\Resources\Skillsets\Tables\SkillsetsTable;
use App\Models\Skillset;
use BackedEnum;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SkillsetResource extends Resource
{
    protected static ?string $model = Skillset::class;

    protected static string|BackedEnum|null $navigationIcon = Phosphor::ChartPolar;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static null|string $modelLabel = 'Key Skill';

    protected static ?string $recordTitleAttribute = 'name';

    protected static null|int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SkillsetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SkillsetsTable::configure($table);
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
            'index' => ListSkillsets::route('/'),
        ];
    }
}
