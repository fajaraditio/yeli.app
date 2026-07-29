<?php

namespace App\Filament\Administrator\Resources\Students\Schemas;

use App\Models\Classroom;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Student Information')
                    ->description('Fill in the student information below.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Student Name')
                            ->placeholder('Example: Aditya Yeli Pratama')
                            ->prefixIcon(Phosphor::User)
                            ->required(),

                        TextInput::make('code')
                            ->label('Student ID')
                            ->placeholder('Example: 1234567890')
                            ->unique('students', column: 'code', ignoreRecord: true)
                            ->prefixIcon(Phosphor::IdentificationBadge),

                        Select::make('classroom_id')
                            ->label('Classroom')
                            ->prefixIcon(Phosphor::ChalkboardTeacher)
                            ->options(fn() => Classroom::query()->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $classroom = Classroom::find($state);
                                $set('classroom_name', $classroom ? $classroom->name : null);
                            })
                            ->required(),

                        Hidden::make('classroom_name'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Student Account Login')
                    ->description('Fill in the student information below.')
                    ->schema([
                        TextInput::make('email')
                            ->label('Student Email')
                            ->placeholder('Example: aditia@yeliapp.id')
                            ->prefixIcon(Phosphor::Envelope)
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true),

                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('* * * * * * * *')
                            ->password()
                            ->revealable()
                            ->confirmed()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->helperText(fn(string $operation): string => $operation === 'edit'
                                ? 'Leave blank to keep the current password.'
                                : 'Minimum 8 characters.')
                            ->minLength(8),

                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->placeholder('* * * * * * * *')
                            ->password()
                            ->revealable()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->helperText(fn(string $operation): string => $operation === 'edit'
                                ? 'Leave blank to keep the current password.'
                                : 'Minimum 8 characters.')
                            ->minLength(8),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
