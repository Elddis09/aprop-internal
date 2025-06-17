<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoController extends Controller
{
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

        // Tambahkan cek role = Front Office
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'frontoffice'])) {
            $request->session()->regenerate();

            return redirect('/dashboard-fo')->with('success', 'Berhasil masuk dashboard.');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah',
        ]);
    }
    // Dashboard Front Office
    public function dashboard()
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // --- Statistik GLOBAL (Seluruh Sistem) ---
        $totalProposalSistem = Proposal::count();
        $disetujuiSistem = Proposal::where('status', 'selesai')->where('is_finished', true)->count();
        $ditolakSistem = Proposal::where('status', 'ditolak')->where('is_finished', true)->count();
        $dalamProsesSistem = Proposal::whereNotIn('status', ['selesai', 'ditolak'])->count();
        $pendingSistem = Proposal::where('status', 'pending')->count();
        $selesaiSistem = Proposal::where('status', 'selesai')->count();


        // --- Statistik Spesifik Front Office ---

        // Proposal di Kotak Masuk FO (yang saat ini berada di posisi FO)
        $kotakMasukFo = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->whereIn('status', ['diterima', 'diproses', 'pending']) 
            ->count();
        $dalamProsesOlehFO = Proposal::where('user_id', $user->id)
            ->whereDoesntHave('currentTrack', function ($query) use ($userRole) {
                $query->where('to_position', $userRole); // Tidak lagi di posisi FO
            })
            ->whereNotIn('status', ['selesai', 'ditolak']) // Belum selesai/ditolak
            ->count();
        $proposalSelesaiDiajukanFO = Proposal::where('user_id', $user->id)
            ->whereIn('status', ['selesai', 'ditolak']) // Status final
            ->where('is_finished', true)
            ->count();

        return view('Pages.Dashboard.dashboard-fo', compact(
            'totalProposalSistem',
            'disetujuiSistem',
            'ditolakSistem',
            'dalamProsesSistem',
            'pendingSistem',
            'selesaiSistem',
            'kotakMasukFo',
            'dalamProsesOlehFO',
            'proposalSelesaiDiajukanFO'
        ));
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
