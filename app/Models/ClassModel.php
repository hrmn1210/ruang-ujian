<?php

// app/Models/ClassModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Eksplisit mendefinisikan nama tabel
    protected $fillable = ['name'];

    // Relasi: Satu Kelas memiliki banyak Murid
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // Relasi: Satu Kelas bisa memiliki banyak Ujian
    public function exams()
    {
        return $this->hasMany(Exam::class, 'class_id');
    }
}
