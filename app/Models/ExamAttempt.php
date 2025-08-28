<?php

// app/Models/ExamAttempt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_id',
        'score',
        'started_at',
        'finished_at',
        'finished_by_violation',
    ];

    // Relasi: Sesi pengerjaan ini milik satu Murid
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi: Sesi pengerjaan ini untuk satu Ujian
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi: Satu sesi pengerjaan memiliki banyak Jawaban Murid
    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
