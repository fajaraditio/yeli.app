<?php

namespace App\Filament\Lecturer\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\View;
use Override;

class Login extends BaseLogin
{
    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return 'YELI Lecturer';
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Hello 👋! Welcome to YELI — Your English Learning Interface. Please login into your lecturer account below.';
    }

    #[Override]
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Medium;
    }

    #[Override]
    public function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()->placeholder('Example: robert@yeliapp.id');
    }

    #[Override]
    public function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()->placeholder('* * * * * * * *');
    }

    #[Override]
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
                View::make('filament.lecturer.hooks.register-link'),
            ]);
    }
}
