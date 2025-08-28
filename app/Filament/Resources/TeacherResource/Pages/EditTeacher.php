<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make(),];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['name'] = $this->record->user->name;
        $data['email'] = $this->record->user->email;
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update(['nip' => $data['nip']]);
        $record->user->update(['name' => $data['name'], 'email' => $data['email']]);

        if (!empty($data['password'])) {
            $record->user->update(['password' => Hash::make($data['password'])]);
        }
        if (!empty($data['subjects'])) {
            $record->subjects()->sync($data['subjects']);
        }
        return $record;
    }
}
