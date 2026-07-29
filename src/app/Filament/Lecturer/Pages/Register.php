<?php

namespace App\Filament\Lecturer\Pages;

use App\Constants\UserConstant;
use App\Models\Classroom;
use App\Models\Lecturer;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Override;
use SensitiveParameter;

class Register extends BaseRegister
{
    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return 'YELI for Lecturer';
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Hello 👋! Welcome to YELI — Your English Learning Interface. Ready to give teaching about English? Join with us';
    }

    #[Override]
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Medium;
    }

    #[Override]
    public function getNameFormComponent(): Component
    {
        return parent::getNameFormComponent()
            ->label('Full Name')
            ->placeholder('Example: Robert Yeli, Phd');
    }

    public function getCodeFormComponent(): Component
    {
        return TextInput::make('lecturer.code')
            ->label('Lecturer ID')
            ->required()
            ->maxLength(255)
            ->placeholder('Example: 123456789')
            ->unique(table: 'lecturers', column: 'code')
            ->autofocus();
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
    public function getPasswordConfirmationFormComponent(): Component
    {
        return parent::getPasswordConfirmationFormComponent()->placeholder('* * * * * * * *');
    }

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getCodeFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    #[Override]
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                RenderHook::make(PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE),
                $this->getFormContentComponent(),
                View::make('filament.lecturer.hooks.login-link'),
                RenderHook::make(PanelsRenderHook::AUTH_REGISTER_FORM_AFTER),
            ]);
    }

    #[Override]
    protected function handleRegistration(#[SensitiveParameter] array $data): Model
    {
        $lecturer    = $data['lecturer'];

        $data['role'] = UserConstant::Role_Lecturer;

        unset($data['lecturer']);

        $user = $this->getUserModel()::create($data);

        Lecturer::create(array_merge(['user_id' => $user->id], $lecturer));

        return $user;
    }
}
