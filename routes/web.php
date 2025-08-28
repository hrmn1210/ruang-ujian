<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Middleware\VerifyIsMurid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (!Auth::check()) {
        return view('welcome');
    }

    return match (Auth::user()->role) {
        'admin' => redirect()->route('filament.admin.pages.dashboard'),
        'guru'  => redirect()->route('filament.guru.pages.dashboard'),
        'murid' => redirect()->route('student.dashboard'),
        default => redirect()->route('login'),
    };
})->name('home');

// === RUTE OTENTIKASI MANUAL ===
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
// Pastikan baris di bawah ini memiliki ->name('logout')
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');


// === RUTE KHUSUS MURID ===
Route::middleware(['auth', VerifyIsMurid::class])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/ujian/{exam}', [ExamController::class, 'show'])->name('student.exam.show');
        Route::post('/ujian/{exam}', [ExamController::class, 'store'])->name('student.exam.store');
        Route::get('/ujian/bukti/{attempt}', [ExamController::class, 'downloadProof'])->name('student.exam.proof');
    });
Route::post('/ujian/{exam}/force-submit', [ExamController::class, 'forceSubmit'])->name('student.exam.force_submit');
