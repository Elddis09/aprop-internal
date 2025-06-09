<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class klienController extends Controller
{

    // Form registrasi klien
    public function registerForm()
    {
        return view('auth.register');
    }

    // Simpan data registrasi klien
    public function registerStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'klien', // fixed role klien
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }


    // =======================LOGIN=======================
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses login klien
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Tambahkan cek role = klien
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'frontoffice'])) {
            $request->session()->regenerate();

            return redirect('/dashboard-klien')->with('success', 'Berhasil masuk dashboard.');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah',
        ]);
    }
    // Dashboard klien
    public function dashboard()
    {
        $user = Auth::user();
        $proposals = $user->proposals;
        // dd($proposals);

        $total = $user->proposals()->count();
        $ditinjau = $user->proposals()->where('status', 'diproses')->count();
        $disetujui = $user->proposals()->where('status', 'disetujui')->count();
        $ditolak = $user->proposals()->where('status', 'ditolak')->count();

        return view('Pages.dashboard-klien', compact('total', 'ditinjau', 'disetujui', 'ditolak'));
    }
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
