<?php

namespace App\Filament\Guru\Resources\ExamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('question_text')->required()->columnSpanFull()->label('Teks Pertanyaan'),
                Forms\Components\Repeater::make('options')->relationship()->schema([
                    Forms\Components\TextInput::make('option_text')->required()->label('Teks Jawaban'),
                    Forms\Components\Checkbox::make('is_correct')->label('Jawaban Benar?'),
                ])->columns(2)->columnSpanFull()->label('Pilihan Jawaban')->minItems(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text')
            ->columns([Tables\Columns\TextColumn::make('question_text')->html()->limit(50)])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }
}
