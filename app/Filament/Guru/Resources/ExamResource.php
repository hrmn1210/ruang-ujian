<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\ExamResource\Pages;
use App\Filament\Guru\Resources\ExamResource\RelationManagers;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Actions\StaticAction; // <-- TAMBAHKAN BARIS INI

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $modelLabel = 'Ujian';
    protected static ?string $pluralModelLabel = 'Daftar Ujian';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Ujian')->schema([
                    Forms\Components\TextInput::make('title')->label('Judul Ujian')->required(),
                    Forms\Components\Select::make('subject_id')
                        ->relationship('subject', 'name')
                        ->options(fn() => auth()->user()->teacher->subjects()->pluck('subjects.name', 'subjects.id'))
                        ->required()->label('Mata Pelajaran'),
                    Forms\Components\Select::make('class_id')
                        ->relationship('classModel', 'name')->required()->label('Kelas'),
                    Forms\Components\TextInput::make('duration')->numeric()->required()->label('Durasi (menit)'),
                    Forms\Components\DateTimePicker::make('start_time')->required()->label('Waktu Mulai'),
                    Forms\Components\DateTimePicker::make('end_time')->required()->label('Waktu Selesai'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Exam::query()->where('teacher_id', auth()->user()->teacher->id))
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('subject.name')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('classModel.name')->label('Kelas'),
                Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Jumlah Soal'),
            ])
            ->actions([
                Action::make('viewResults')
                    ->label('Lihat Hasil')
                    ->icon('heroicon-o-table-cells')
                    ->color('success')
                    ->modalContent(fn(Exam $record) => view('filament.guru.exam-results-modal', ['exam' => $record]))
                    ->modalHeading(fn(Exam $record) => 'Hasil Ujian: ' . $record->title)
                    ->modalSubmitAction(false)
                    // UBAH "Action" MENJADI "StaticAction" DI SINI
                    ->modalCancelAction(fn(StaticAction $action) => $action->label('Tutup'))
                    ->slideOver(),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }
}
