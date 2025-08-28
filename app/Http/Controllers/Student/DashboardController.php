<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard murid dengan daftar ujian yang tersedia.
     */
    public function index()
    {
        $student = Auth::user()->student;

        // ## LOGIKA QUERY BARU ##
        // Ambil semua ujian yang dijadwalkan HARI INI (dari jam 00:00 hingga 23:59)
        // Kita juga mengambil data percobaan (attempts) untuk setiap ujian
        $exams = Exam::query()
            ->where('class_id', $student->class_id)
            ->whereDate('start_time', today()) // <-- Kunci utamanya di sini
            ->with([
                'subject',
                'questions',
                'examAttempts' => function ($query) use ($student) {
                    $query->where('student_id', $student->id);
                }
            ])
            ->get();

        // Kirim data $exams ke view
        return view('student.dashboard', [
            'exams' => $exams,
        ]);
    }
}
