<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika user sudah login, redirect ke halaman utama
        if (Auth::check()) {
            return redirect()->route('supplier.index');
        }

        return view('login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Attempt to authenticate
        if (Auth::attempt(['name' => $validated['username'], 'password' => $validated['password']])) {
            // Regenerate session ID untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended(route('supplier.index'))
                           ->with('success', 'Login berhasil');
        }

        // Authentication failed
        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'login_error' => 'Username atau password salah',
            ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token CSRF
        $request->session()->regenerateToken();

        return redirect()->route('login')
                       ->with('success', 'Logout berhasil');
    }
}
