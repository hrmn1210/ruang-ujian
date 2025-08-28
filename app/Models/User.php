<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Pastikan ada "implements FilamentUser"
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan 'role' ada di sini
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // Relasi ke Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // ## INI METHOD KUNCI UNTUK MENGATASI LOADING TERUS ##
    public function canAccessPanel(Panel $panel): bool
    {
        // Logika ini memeriksa apakah peran user cocok dengan panel yang diakses
        return match ($panel->getId()) {
            'admin' => $this->role === 'admin',
            'guru' => $this->role === 'guru',
            'murid' => $this->role === 'murid',
            default => false,
        };
    }
}
