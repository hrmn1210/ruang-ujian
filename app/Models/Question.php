<?php

// app/Models/Question.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'question_text'];

    // Relasi: Soal ini milik satu paket Ujian
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi: Satu Soal memiliki banyak Pilihan Jawaban
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
