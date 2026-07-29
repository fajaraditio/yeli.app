<?php

namespace App\Filament\Administrator\Resources\Students\Schemas;

use App\Constants\UserConstant;
use Filafly\Icons\Phosphor\Enums\Phosphor;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Student Information')
                    ->description('Basic information about this student.')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Student Name'),

                        TextEntry::make('code')
                            ->label('Student ID')
                            ->placeholder('—')
                            ->copyable(),

                        TextEntry::make('classroom_name')
                            ->label('Classroom')
                            ->placeholder('—'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Student Account')
                    ->description('Login credentials linked to this student.')
                    ->schema([
                        TextEntry::make('user.email')
                            ->label('Student Email')
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
