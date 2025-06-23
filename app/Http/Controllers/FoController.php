<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalTrack;
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
        $dalamProsesSistem = Proposal::where(function ($query) {
            $query->where('status', '!=', 'selesai')
                ->orWhere('is_finished', false);
        })
            ->where('status', '!=', 'ditolak')
            ->where('status', '!=', 'cancel')
            ->where('status', '!=', 'pending')
            ->count();
        $pendingSistem = Proposal::where('status', 'pending')->count();
        $cancelSistem = Proposal::where('status', 'cancel')->count();
        $selesaiSistem = Proposal::where('status', 'selesai')->count();


        // --- Statistik Spesifik Front Office ---

        // Proposal di Kotak Masuk FO (yang saat ini berada di posisi FO)
        $kotakMasukFo = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole)
                ->where('is_current', true);
        })
            ->whereIn('status', ['diterima', 'pending'])
            ->where('status', '!=', 'cancel')
            ->where('is_finished', false)
            ->count();

        $dalamProsesOlehFO = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->where('status', 'diproses') // Hanya status 'diproses'
            ->count();

        $proposalSelesaiDiajukanFO = ProposalTrack::where('actor_id', $user->id)
            ->where('status_label', 'like', '%Disetujui%') // Menangkap 'Proposal Disetujui' atau 'Proposal Disetujui dan Diteruskan'
            ->count();


        $proposalCancelFO = Proposal::where('status', 'cancel')
            ->where('is_finished', true)
            ->whereHas('currentTrack', function ($query) use ($user) {
                $query->where('actor_id', $user->id) // Aktor yang mengubah status ke 'cancel' adalah user FO ini
                    ->where('is_current', true);
            })
            ->count();

        return view('Pages.Dashboard.dashboard-fo', compact(
            'totalProposalSistem',
            'disetujuiSistem',
            'ditolakSistem',
            'dalamProsesSistem',
            'cancelSistem',
            'pendingSistem',
            'selesaiSistem',
            'kotakMasukFo',
            'dalamProsesOlehFO',
            'proposalSelesaiDiajukanFO',
            'proposalCancelFO',
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
