<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class SuperadminController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    // Proses login superadmin
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Tambahkan cek role = superadmin
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'superadmin'])) {
            $request->session()->regenerate();

            return redirect('/dashboard-admin')->with('success', 'Berhasil masuk dashboard.');
        }


        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah',
        ]);
    }

    // Dashboard Superadmin
    public function dashboard()
    {
        $user = Auth::user();
        $proposals = Proposal::all();

        $total = Proposal::count();
        $perluTindakan = Proposal::where('status', 'diterima')->count();
        $dalamProses = Proposal::where('status', 'diproses')->count();
        $diterima = Proposal::where('status', 'diterima')->count();
        $disetujui = Proposal::where('status', 'disetujui')->count();
        $ditolak = Proposal::where('status', 'ditolak')->count();


        return view('Pages.dashboard-admin', compact('total', 'perluTindakan', 'dalamProses', 'disetujui', 'ditolak', 'diterima'));
    }





    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function create()
    {

        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('Pages.user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,frontoffice,backoffice,stafpimpinan,sekretarisumum,stafbinpres,binpres,sekretarisii,ketuaii,ketuaumum,keuangan,bai,klien'
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('superadmin.data-user')->with('success', 'User berhasil dibuat!');
    }

    public function dataUser()
    {
        $users = User::all();
        return view('Pages.data-user', compact('users'));
    }

    public function deleteUser($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $user = User::findOrFail($id);

        // Mencegah superadmin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.data-user')->with('success', 'User berhasil dihapus.');
    }
}
