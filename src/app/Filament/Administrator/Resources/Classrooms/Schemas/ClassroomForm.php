<?php

namespace App\Filament\Administrator\Resources\Classrooms\Schemas;

use App\Models\Classroom;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Classroom Name')
                    ->placeholder('Example: English 1')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (callable $set, callable $get, ?string $state, string $operation, ?Classroom $record) {
                        if (blank($state)) return;

                        if ($operation === 'edit' && filled($get('code'))) return;

                        $set('code', static::generateCode($state, $record?->id));
                    })
                    ->autofocus()
                    ->columnSpanFull(),

                TextInput::make('code')
                    ->label('Classroom Code')
                    ->placeholder('Example: ENG-1')
                    ->readOnly()
                    ->helperText('Classroom Code will generate automatically')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    protected static function generateCode(string $name, ?int $ignoreId = null): string
    {
        $prefix = strtoupper(Str::substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
        $prefix = $prefix ?: 'CLS';

        $number = 1;

        while (
            Classroom::query()
            ->where('code', "{$prefix}-{$number}")
            ->when($ignoreId, fn($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $number++;
        }

        return "{$prefix}-{$number}";
    }
}
