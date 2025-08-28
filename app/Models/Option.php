<?php

// app/Models/Option.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'option_text', 'is_correct'];

    // Relasi: Pilihan ini milik satu Soal
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
