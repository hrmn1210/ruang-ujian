<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Murid';
    protected static ?string $pluralModelLabel = 'Murid';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nisn')
                    ->required()->unique(ignoreRecord: true)->maxLength(50),
                Forms\Components\Select::make('class_id')
                    ->relationship('classModel', 'name')->required()->label('Kelas'),
                Forms\Components\Section::make('Akun Murid')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()->label('Nama Lengkap'),
                        Forms\Components\TextInput::make('email')
                            ->required()->email()->label('Email')
                            ->rule(function (string $context, $livewire) {
                                if ($context === 'create') {
                                    return Rule::unique('users', 'email');
                                }
                                $userIdToIgnore = $livewire->record->user_id;
                                return Rule::unique('users', 'email')->ignore($userIdToIgnore);
                            }),
                        Forms\Components\TextInput::make('password')
                            ->password()->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))->label('Password')
                            ->hint('Isi hanya jika ingin mengubah password.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nisn')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nama Murid')->searchable(),
                Tables\Columns\TextColumn::make('classModel.name')->label('Kelas')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class_id')
                    ->relationship('classModel', 'name')->label('Filter Kelas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // <-- Tombol Hapus Ditambahkan
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
