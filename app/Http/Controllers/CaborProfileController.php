<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CaborProfileController extends Controller
{
    public function index()
    {
        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 30,
        ])->get('https://koni-kotabandung.or.id/api/cabor');

        if ($response->successful()) {
            $caborData = $response->json();
        } else {
            $caborData = [];
            Log::error('Gagal mengambil data dari API Cabor');
        }

        $mitras = Mitra::all();
        $mitrasArray = $mitras->map(function ($mitra) {
            return [
                'id_cabor' => 'mitra-' . $mitra->id,
                'nama_cabor' => strtoupper($mitra->nama),
                'tipe' => 'mitra',
            ];
        })->toArray();

        $allPengaju = array_merge($caborData, $mitrasArray);
        $user = Auth::user();

        return view('Pages.profile-cabor', compact('user', 'allPengaju'));
    }

    public function update(Request $request, $id)
    {
        // Ambil data cabor dari API
        $response = Http::withOptions([
            'verify' => false,  // Menonaktifkan verifikasi SSL sementara 
            'timeout' => 30,
        ])->get('https://koni-kotabandung.or.id/api/cabor');

        // Memastikan data dari API berhasil diterima
        if ($response->successful()) {
            $caborData = $response->json();
        } else {
            $caborData = [];
            Log::error('Gagal mengambil data dari API Cabor');
        }

        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Menyimpan data yang akan diperbarui
        $updatedData = [];

        // Jika memilih "lainnya" untuk cabang olahraga, buat mitra baru
        if ($request->cabang_olahraga === 'lainnya') {
            $namaMitraBaru = strtoupper(trim($request->input('nama_mitra_baru')));

            // Cek apakah mitra dengan nama yang sama sudah ada
            $existingMitra = Mitra::whereRaw('UPPER(nama) = ?', [$namaMitraBaru])->first();

            if ($existingMitra) {
                // Jika sudah ada, gunakan mitra yang ada
                $updatedData['cabor_id'] = 'mitra-' . $existingMitra->id;
            } else {
                // Jika belum ada, buat mitra baru dan simpan
                $mitraBaru = Mitra::create([
                    'nama' => $namaMitraBaru,
                    'tipe' => 'mitra', // Tipe mitra yang baru
                ]);
                // Update cabor_id dengan mitra baru yang disimpan
                $updatedData['cabor_id'] = 'mitra-' . $mitraBaru->id;
                Log::info('Mitra baru disimpan, cabor_id diupdate:', ['cabor_id' => 'mitra-' . $mitraBaru->id]);
            }
        } else {
            // Jika tidak memilih "lainnya", update dengan data cabor dari API
            if ($request->has('cabang_olahraga') && $user->cabor_id != $request->cabang_olahraga) {
                $updatedData['cabor_id'] = $request->cabang_olahraga;
            }
        }

        // Update data lainnya jika ada perubahan
        if ($request->has('name') && $user->name != $request->name) {
            $updatedData['name'] = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $updatedData['email'] = $request->email;
        }

        if ($request->has('no_telepon') && $user->no_telepon != $request->no_telepon) {
            $updatedData['no_telepon'] = $request->no_telepon;
        }

        if ($request->has('jabatan') && $user->jabatan != $request->jabatan) {
            $updatedData['jabatan'] = $request->jabatan;
        }

        if ($request->has('alamat') && $user->alamat != $request->alamat) {
            $updatedData['alamat'] = $request->alamat;
        }

        if ($request->has('kota') && $user->kota != $request->kota) {
            $updatedData['kota'] = $request->kota;
        }

        // Lakukan update hanya jika ada perubahan data
        if (!empty($updatedData)) {
            $user->update($updatedData);
        }

        // Menyelesaikan dengan mengarahkan ke halaman profil
        return redirect()->route('klien.profil-cabor.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
