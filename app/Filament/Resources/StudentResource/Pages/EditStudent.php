<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

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
        $record->update(['nisn' => $data['nisn'], 'class_id' => $data['class_id']]);
        $record->user->update(['name' => $data['name'], 'email' => $data['email']]);

        if (!empty($data['password'])) {
            $record->user->update(['password' => Hash::make($data['password'])]);
        }
        return $record;
    }
}
