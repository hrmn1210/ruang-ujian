<?php

// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'class_id', 'nisn'];

    // Relasi: Profil Murid ini milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Murid ini berada di satu Kelas
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relasi: Satu Murid bisa mengerjakan banyak Ujian
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
