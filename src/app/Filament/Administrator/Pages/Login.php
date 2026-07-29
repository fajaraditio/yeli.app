<?php

namespace App\Filament\Administrator\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Component;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Override;

class Login extends BaseLogin
{
    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return 'YELI App';
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Welcome to YELI — Your English Learning Interface. Please login into your administrator account below.';
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
}
