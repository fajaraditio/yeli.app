<?php

namespace App\Filament\Administrator\Resources\Students\Pages;

use App\Filament\Administrator\Resources\Students\StudentResource;
use App\Models\Classroom;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Override;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    #[Override]
    public function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = $this->record->user->toArray();

        return $data;
    }

    #[Override]
    public function handleRecordUpdate(Model $record, array $data): Model
    {
        $user = $data['user'];

        $classroom  = Classroom::find($data['classroom_id']);

        $data['classroom_name'] = $classroom->name;

        unset($data['user']);
        unset($user['password_confirmation']);

        $record->user()->update($user);

        return parent::handleRecordUpdate($record, $data);
    }
}
