<?php

// app/Models/Subject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi: Satu Mapel bisa diajar banyak Guru (Many to Many)
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }

    // Relasi: Satu Mapel bisa memiliki banyak Ujian
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
