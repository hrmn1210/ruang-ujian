<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'guru',
        ]);

        $teacher = static::getModel()::create([
            'user_id' => $user->id,
            'nip' => $data['nip'],
        ]);

        if (!empty($data['subjects'])) {
            $teacher->subjects()->sync($data['subjects']);
        }
        return $teacher;
    }
}
