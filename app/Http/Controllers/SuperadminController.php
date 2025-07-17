<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalTrack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class SuperadminController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'role' => 'superadmin'])) {
            $request->session()->regenerate();

            return redirect('/dashboard-admin')->with('success', 'Berhasil masuk dashboard.');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah',
        ]);
    }

    // DASHBOARD
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
        $selesaiSistem = Proposal::where('status', 'selesai')->count(); // Total yang sudah berakhir (disetujui/ditolak final)

        $kotakMasukRoleSaatIni = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->whereIn('status', ['diterima', 'disetujui']) // <--- Ubah di sini
            ->where('is_finished', false)
            ->count();

        $dalamProsesOlehRoleIni = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->where('status', 'diproses') // Hanya status 'diproses'
            ->count();
        $pendingOlehRoleIni = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->where('status', 'pending') // Spesifik untuk status 'pending'
            ->count();
        $disetujuiOlehRoleIni = ProposalTrack::where('actor_id', $user->id)
            ->where('status_label', 'like', '%Disetujui%') // Menangkap 'Proposal Disetujui' atau 'Proposal Disetujui dan Diteruskan'
            ->count();

        $ditolakOlehRoleIni = ProposalTrack::where('actor_id', $user->id)
            ->where('status_label', 'like', '%Ditolak%') // Menangkap 'Proposal Ditolak' atau 'Proposal Ditolak Secara Final'
            ->count();
        $dicancelOlehRoleIni = ProposalTrack::where('actor_id', $user->id)
            ->where('status_label', 'like', '%cancel%') // Menangkap 'Proposal Ditolak' atau 'Proposal Ditolak Secara Final'
            ->count();

        return view('Pages.Dashboard.dashboard-admin', compact(
            'totalProposalSistem',
            'disetujuiSistem',
            'ditolakSistem',
            'dalamProsesSistem',
            'pendingSistem',
            'selesaiSistem',
            'kotakMasukRoleSaatIni',
            'dalamProsesOlehRoleIni',
            'pendingOlehRoleIni',
            'disetujuiOlehRoleIni',
            'ditolakOlehRoleIni',
            'dicancelOlehRoleIni',
            'cancelSistem'
        ));
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // FORM CREATE USER
    public function create()
    {

        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('Pages.User.create-user');
    }

    // PROSES CREATE USER
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,frontoffice,backoffice,stafpimpinan,sekretarisumum,stafbinpres,binpres,sekretarisdua,ketuadua,ketuaumum,keuangan,bai,stafumum,bidangumum,sekretaristiga,ketuatiga',
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

    // DATA USER
    public function dataUser()
    {
        $users = User::all();
        return view('Pages.User.data-user', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('Pages.user.edit-user', compact('user'));
    }


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string',
        'username' => 'required|string|unique:users,username,' . $user->id,
        'role' => 'required|string',
        'email' => 'nullable|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
    ]);

    $user->name = $validated['name'];
    $user->username = $validated['username'];
    $user->role = $validated['role'];

    if (!empty($validated['email'])) {
        $user->email = $validated['email'];
    }

    // Jika password diisi, update password & waktu perubahan
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
        $user->password_changed_at = now();
    }

    $user->save();

    return redirect()->route('superadmin.data-user')->with('success', 'User berhasil diperbarui.');
}

// public function resetPassword($id)
// {
//     $user = User::findOrFail($id);
//     $user->password = Hash::make('123456');
//     $user->password_changed_at = now(); 
//     $user->save();

//     return redirect()->route('superadmin.data-user')->with('success', 'Password berhasil direset ke default (123456).');
// }

    // DELETE USER
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
