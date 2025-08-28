<?php

namespace App\Filament\Guru\Resources\ExamResource\Pages;

use App\Filament\Guru\Resources\ExamResource;
use App\Models\Exam;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListExams extends ListRecords
{
    protected static string $resource = ExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importSoal')
                ->label('Import Soal dari Word')->icon('heroicon-o-document-arrow-up')
                ->form([
                    Select::make('exam_id')->label('Pilih Ujian Tujuan')
                        ->options(Exam::query()->where('teacher_id', auth()->user()->teacher->id)->pluck('title', 'id'))
                        ->required(),
                    FileUpload::make('attachment')->label('File Soal (.docx)')->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                ])
                ->action(function (array $data) {
                    $filePath = storage_path('app/public/' . $data['attachment']);
                    $exam = Exam::find($data['exam_id']);
                    $importedCount = 0;
                    try {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                        $content = '';
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                                    $lineText = '';
                                    foreach ($element->getElements() as $textElement) {
                                        if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                            $lineText .= $textElement->getText();
                                        }
                                    }
                                    $content .= $lineText . "\n";
                                }
                            }
                        }

                        $lines = preg_split('/[\r\n]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
                        $questionData = null;
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (preg_match('/^(\d+)\.\s(.+)/', $line, $matches)) {
                                if ($questionData) {
                                    if ($this->saveQuestion($exam, $questionData)) $importedCount++;
                                }
                                $questionData = ['text' => $matches[2], 'options' => []];
                            } elseif (preg_match('/^(\*?)\s*([A-E])\.\s(.+)/', $line, $matches) && $questionData) {
                                $isCorrect = ($matches[1] === '*');
                                $questionData['options'][] = ['text' => $matches[3], 'is_correct' => $isCorrect];
                            }
                        }
                        if ($questionData) {
                            if ($this->saveQuestion($exam, $questionData)) $importedCount++;
                        }

                        if ($importedCount > 0) {
                            Notification::make()->title('Import Berhasil!')->body("Berhasil menambahkan {$importedCount} soal.")->success()->send();
                        } else {
                            Notification::make()->title('Gagal Membaca Soal')->body('Tidak ada soal yang ditemukan. Periksa kembali format file Word Anda.')->warning()->send();
                        }
                    } catch (\Exception $e) {
                        Notification::make()->title('Import Gagal!')->body('Terjadi kesalahan: ' . $e->getMessage())->danger()->send();
                    }
                }),
        ];
    }

    protected function saveQuestion(Exam $exam, array $questionData): bool
    {
        if (empty($questionData['text']) || empty($questionData['options'])) return false;
        $question = $exam->questions()->create(['question_text' => $questionData['text']]);
        foreach ($questionData['options'] as $option) {
            $question->options()->create(['option_text' => $option['text'], 'is_correct' => $option['is_correct']]);
        }
        return true;
    }
}
