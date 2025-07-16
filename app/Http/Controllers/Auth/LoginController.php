<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan formulir login
    public function showLoginForm()
    {
        return view('auth.login'); // Ini akan me-render file resources/views/auth/login.blade.php
    }

    // Memproses permintaan login
    public function login(Request $request)
    {
        // Validasi input username dan password
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba autentikasi pengguna menggunakan username
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate(); // Regenerasi sesi untuk keamanan

            // Dapatkan role pengguna yang baru saja login
            $role = Auth::user()->role;

            // Arahkan pengguna ke dashboard yang sesuai berdasarkan role
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else { // role 'user'
                return redirect()->intended('/pengajuan');
            }
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Memproses permintaan logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus data sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/'); // Arahkan ke halaman utama atau halaman login
    }
}