<?php

namespace App\Filament\Administrator\Resources\Lecturers\Schemas;

use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LecturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lecturer Information')
                    ->description('Fill in the Lecturer information below.')
                    ->schema([
                        TextInput::make('user.name')
                            ->label('Lecturer Name')
                            ->placeholder('Example: Dr. Aditya Yeli Pratama')
                            ->prefixIcon(Phosphor::User)
                            ->required(),

                        TextInput::make('code')
                            ->label('Lecturer ID')
                            ->placeholder('Example: 1234567890')
                            ->unique(table: 'lecturers', column: 'code', ignoreRecord: true)
                            ->prefixIcon(Phosphor::IdentificationBadge),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Lecturer Account Login')
                    ->description('Fill in the Lecturer information below.')
                    ->schema([
                        TextInput::make('user.email')
                            ->label('Lecturer Email')
                            ->placeholder('Example: aditia@yeliapp.id')
                            ->prefixIcon(Phosphor::Envelope)
                            ->email()
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignorable: fn($record) => $record->user
                            ),

                        TextInput::make('user.password')
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

                        TextInput::make('user.password_confirmation')
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
