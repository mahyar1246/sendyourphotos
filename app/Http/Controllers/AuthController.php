<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan halaman desain UI Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Fungsi untuk memproses data saat tombol "Sign In" ditekan
    public function authenticate(Request $request)
    {
        // 1. Validasi inputan form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek email dan password ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // PERUBAHAN: Diarahkan ke Dashboard setelah login sukses
            return redirect()->intended('/dashboard'); 
        }

        // 3. Jika gagal login, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Fungsi untuk menampilkan halaman form register
    public function showRegister()
    {
        return view('auth.register'); // SUDAH DIUPDATE
    }

    // Fungsi untuk memproses data pendaftaran ke database
    public function processRegister(Request $request)
    {
        // 1. Validasi inputan form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'gender' => 'required|in:L,P',
            'role' => 'required|in:buyer,contributor',
            'password' => 'required|min:8|confirmed', 
        ]);

        // 2. Simpan user baru ke database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), 
            'gender' => $validated['gender'],
            'role' => $validated['role'],
        ]);

        // 3. Langsung login-kan user setelah berhasil mendaftar
        Auth::login($user);

        // PERUBAHAN: Diarahkan ke Dashboard setelah registrasi sukses
        return redirect()->intended('/dashboard');
    }

    // ==========================================
    // FUNGSI LUPA & RESET PASSWORD
    // ==========================================

   // ==========================================
    // FUNGSI GANTI SANDI LANGSUNG (BYPASS)
    // ==========================================

    // 1. Menampilkan form ganti sandi
    public function showDirectReset()
    {
        return view('auth.direct-reset');
    }

    // 2. Memproses perubahan sandi tanpa token email
    public function processDirectReset(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|exists:users,email', // Pastikan email ada di database
            'password' => 'required|min:8|confirmed', // Harus cocok dengan password_confirmation
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Ganti passwordnya dan simpan
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Sandi berhasil diubah secara instan! Silakan login dengan sandi baru Anda.');
    }
}

