<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'teacher_id',
        'subject_id',
        'class_id',
        'duration',
        'start_time',
        'end_time',
    ];

    // Relasi: Ujian ini dibuat oleh satu Guru
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relasi: Ujian ini untuk satu Mata Pelajaran
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi: Ujian ini untuk satu Kelas
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relasi: Satu Ujian memiliki banyak Soal
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // ## RELASI YANG PERLU DITAMBAHKAN ADA DI SINI ##
    // Relasi: Satu Ujian bisa memiliki banyak percobaan pengerjaan
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
