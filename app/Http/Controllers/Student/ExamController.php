<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Option;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class ExamController extends Controller
{
    /**
     * Menampilkan halaman pengerjaan ujian.
     */
    public function show(Exam $exam)
    {
        $student = Auth::user()->student;

        if ($exam->class_id !== $student->class_id) {
            abort(403, 'Ujian ini bukan untuk kelas Anda.');
        }

        $attempt = ExamAttempt::firstOrCreate(
            ['exam_id' => $exam->id, 'student_id' => $student->id],
            ['started_at' => now()]
        );

        if ($attempt->finished_at) {
            return redirect()->route('student.dashboard')->with('error', 'Anda sudah menyelesaikan ujian ini.');
        }

        $finishTime = Carbon::parse($attempt->started_at)->addMinutes($exam->duration);

        $questions = $exam->questions()->with('options')->get();

        return view('student.exam_page', [
            'exam' => $exam,
            'questions' => $questions,
            'attempt' => $attempt,
            'finishTime' => $finishTime->toIso8601String(),
        ]);
    }

    /**
     * Memproses dan menilai jawaban ujian.
     */
    public function store(Request $request, Exam $exam)
    {
        $student = Auth::user()->student;
        $request->validate(['answers' => 'required|array']);

        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->whereNull('finished_at')
            ->firstOrFail();

        $totalQuestions = $exam->questions()->count();
        $correctAnswers = 0;
        $submittedAnswers = $request->input('answers');

        foreach ($submittedAnswers as $questionId => $optionId) {
            $option = Option::find($optionId);
            if ($option && $option->is_correct) {
                $correctAnswers++;
            }

            StudentAnswer::create([
                'exam_attempt_id' => $attempt->id,
                'question_id' => $questionId,
                'option_id' => $optionId,
            ]);
        }

        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $attempt->update([
            'finished_at' => now(),
            'score' => $score,
        ]);

        return redirect()->route('student.dashboard')->with('success', "Ujian selesai! Skor Anda: " . round($score));
    }

    /**
     * Membuat dan men-download bukti pengerjaan ujian dalam format PDF.
     */
    public function downloadProof(ExamAttempt $attempt)
    {
        if (Auth::user()->student->id !== $attempt->student_id) {
            abort(403, 'Akses Ditolak');
        }

        $totalQuestions = $attempt->exam->questions()->count();
        $correctAnswers = round(($attempt->score / 100) * $totalQuestions);
        $incorrectAnswers = $totalQuestions - $correctAnswers;

        $startTime = Carbon::parse($attempt->started_at);
        $finishTime = Carbon::parse($attempt->finished_at);
        $duration = $startTime->diff($finishTime)->format('%H jam, %i menit, %s detik');

        $data = [
            'attempt' => $attempt,
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $incorrectAnswers,
            'duration' => $duration,
        ];

        $pdf = PDF::loadView('student.exam_receipt', $data);

        $filename = 'bukti-ujian-' . str_replace(' ', '-', strtolower($attempt->exam->title)) . '.pdf';
        return $pdf->stream($filename);
    }
    // app/Http/Controllers/Student/ExamController.php

    /**
     * Memproses ujian yang selesai secara paksa (karena pelanggaran).
     */
    public function forceSubmit(Request $request, Exam $exam)
    {
        // Logika untuk menghitung skor dan menyimpan ke database tetap sama
        $student = Auth::user()->student;
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->whereNull('finished_at')
            ->first();

        // Jika attempt tidak ditemukan atau sudah selesai, hentikan.
        if (!$attempt) {
            return response()->json(['status' => 'already_finished'], 200);
        }

        $totalQuestions = $exam->questions()->count();
        $correctAnswers = 0;
        $submittedAnswers = $request->input('answers', []);

        if (!empty($submittedAnswers)) {
            foreach ($submittedAnswers as $questionId => $optionId) {
                StudentAnswer::firstOrCreate(
                    ['exam_attempt_id' => $attempt->id, 'question_id' => $questionId],
                    ['option_id' => $optionId]
                );
                $option = Option::find($optionId);
                if ($option && $option->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $attempt->update([
            'finished_at' => now(),
            'score' => $score,
            'finished_by_violation' => true,
        ]);

        // Kembalikan response JSON, bukan redirect.
        return response()->json(['status' => 'success', 'score' => round($score)]);
    }
}
