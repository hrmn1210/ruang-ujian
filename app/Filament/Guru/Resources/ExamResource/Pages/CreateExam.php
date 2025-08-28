<?php

namespace App\Filament\Guru\Resources\ExamResource\Pages;

use App\Filament\Guru\Resources\ExamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExam extends CreateRecord
{
    protected static string $resource = ExamResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['teacher_id'] = auth()->user()->teacher->id;
        return $data;
    }
}
