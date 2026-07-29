<?php

namespace App\Filament\Administrator\Resources\Lecturers\Schemas;

use App\Constants\UserConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LecturerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lecturer Information')
                    ->description('Basic information about this lecturer.')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Lecturer Name'),

                        TextEntry::make('code')
                            ->label('Lecturer ID')
                            ->placeholder('—')
                            ->copyable(),

                        TextEntry::make('classroom_name')
                            ->label('Classroom')
                            ->placeholder('—'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Lecturer Account')
                    ->description('Login credentials linked to this lecturer.')
                    ->schema([
                        TextEntry::make('user.email')
                            ->label('Lecturer Email')
                            ->copyable(),

                        TextEntry::make('user.status')
                            ->label('Account Status')
                            ->badge()
                            ->color(fn(?string $state): string => UserConstant::Status_Colors[$state] ?? 'gray')
                            ->icon(fn(?string $state): Phosphor|string|null => UserConstant::Status_Icons[$state] ?? null),

                        TextEntry::make('user.email_verified_at')
                            ->label('Email Verified')
                            ->dateTime()
                            ->placeholder('Not verified yet')
                            ->icon(Phosphor::SealCheck),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->since(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }
}
