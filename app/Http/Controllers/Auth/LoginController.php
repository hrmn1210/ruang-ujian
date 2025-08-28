<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Menangani percobaan otentikasi.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba untuk melakukan login
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerate session
            $request->session()->regenerate();

            // Arahkan ke halaman utama, yang akan mengarahkan lagi berdasarkan peran
            return redirect()->intended('/');
        }

        // 3. Jika gagal, kembalikan ke form login dengan pesan error
        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Menangani proses logout.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman utama (yang akan menampilkan halaman login)
        return redirect('/');
    }
}
