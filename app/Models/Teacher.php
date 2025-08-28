<?php

// app/Models/Teacher.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nip'];

    // Relasi: Profil Guru ini milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu Guru bisa mengajar banyak Mapel (Many to Many)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    // Relasi: Satu Guru bisa membuat banyak Ujian
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
