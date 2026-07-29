<?php

namespace App\Filament\Student\Pages;

use App\Models\Classroom;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Events\Registered;
use Filament\Auth\Http\Responses\RegistrationResponse;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Override;

class Register extends BaseRegister
{
    #[Override]
    public function getHeading(): string|Htmlable|null
    {
        return 'YELI App';
    }

    #[Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Hello 👋! Welcome to YELI — Your English Learning Interface. Ready to study comprehensively with us? Join with us';
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
            ->placeholder('Example: Robert Yeli');
    }

    public function getCodeFormComponent(): Component
    {
        return TextInput::make('student.code')
            ->label('Student ID')
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

    public function getClassroomFormComponent(): Component
    {
        return Select::make('student.classroom_id')
            ->label('Class Room')
            ->options(Classroom::all()->pluck('name', 'id'))
            ->searchable()
            ->selectablePlaceholder(false)
            ->native(false);
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
                $this->getClassroomFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    #[Override]
    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
                View::make('filament.student.hooks.register-link'),
            ]);
    }

    #[Override]
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        if ($this->isRegisterRateLimited($this->data['email'] ?? '')) {
            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function (): Model {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}
