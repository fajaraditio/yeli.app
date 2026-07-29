<?php

namespace App\Filament\Lecturer\Pages;

use App\Models\Classroom;
use App\Models\Lecturer;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
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
        return 'YELI App';
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
            ->placeholder('Example: Robert Yeli');
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

    public function getClassroomFormComponent(): Component
    {
        return Select::make('lecturer.classroom_id')
            ->label('Class Room')
            ->options(Classroom::all()->pluck('name', 'id'))
            ->searchable()
            ->selectablePlaceholder(false)
            ->live()
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
                View::make('filament.lecturer.hooks.register-link'),
            ]);
    }

    #[Override]
    protected function handleRegistration(#[SensitiveParameter] array $data): Model
    {
        $lecturer    = $data['lecturer'];

        unset($data['lecturer']);

        $user = $this->getUserModel()::create($data);

        Lecturer::create(array_merge(['user_id' => $user->id], $lecturer));

        return $user;
    }
}
