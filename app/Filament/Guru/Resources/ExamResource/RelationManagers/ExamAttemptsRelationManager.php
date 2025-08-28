<?php

namespace App\Filament\Guru\Resources\ExamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'examAttempts';

    // Mengubah judul tabel
    protected static ?string $title = 'Hasil Pengerjaan Murid';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kita tidak perlu form karena ini hanya untuk menampilkan
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('student.user.name')
                    ->label('Nama Murid')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Skor Akhir')
                    ->numeric()
                    ->sortable()
                    ->suffix('%'),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Selesai Mengerjakan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            // Menonaktifkan tombol "New", "Edit", "Delete"
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
