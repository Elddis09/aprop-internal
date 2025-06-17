<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Proposal;
use App\Models\ProposalTrack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Cabor;
use Illuminate\Validation\Rule;

class ProposalController extends Controller
{
    // DATA PROPOSAL PER ROLE
    public function dataProposal(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        $query = Proposal::query();

        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('judul_berkas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%');
            });
        }

        $proposals = $query->whereHas('tracks', function ($q) use ($userRole) {
            $q->where('to_position', $userRole);
        })
            ->with('mitra', 'currentTrack.actorUser')
            ->latest()
            ->get();

        return view('Pages.Proposal.data-proposal', compact('proposals'));
    }

    // BANK PROPOSAL
    public function bankProposals(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);
        $globalViewRoles = [
            'superadmin',
            'ketuaumum',
            'sekretarisumum',
            'frontoffice',
            'binpres',
            'backoffice',
            'stafpimpinan',
            'sekretarisdua',
            'ketuadua',
            'keuangan',
            'bai',
            'stafbinpres'
        ];

        if (!in_array($userRole, $globalViewRoles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat Bank Proposal.');
        }

        $query = Proposal::query();

        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('judul_berkas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%');
            });
        }

        $proposals = $query->with('mitra', 'currentTrack.actorUser')->latest()->get();

        return view('Pages.Proposal.bank-proposal', compact('proposals'));
    }

    // FORM CREATE AJUAN PROPOSAL
    public function create()
    {
        // Ambil data cabang olahraga dari API
        $caborData = Cabor::all();

        $user = Auth::user();
        $mitras = Mitra::all();

        $currentCaborName = null;
        if ($user->cabor_id) {
            foreach ($caborData as $cabor) {
                if ($cabor['id_cabor'] == $user->cabor_id) {
                    $currentCaborName = $cabor['nama_cabor'];
                    break;
                }
            }
        }

        return view('Pages.Proposal.create-proposal', compact('user', 'caborData', 'currentCaborName', 'mitras'));
    }

    // STORE PROPOSAL KE DATABASE
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_berkas' => 'required|string|max:255',
            'pengaju' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_berkas' => 'required|array',
            'jenis_berkas.*' => 'in:surat,proposal,barang',
            'ringkasan_berkas' => 'required|string',
            'tujuan_berkas' => 'required|string',
            'cabang_olahraga' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
            'tgl_pengajuan' => 'required|date',
            'file_utama' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'nama_petugas' => 'required|string|max:255',
            'nama_mitra_baru' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cabang_olahraga') == 'lainnya';
                }),
            ],
        ]);

        $mitraId = null;
        $cabangOlahragaForProposal = null; // Variabel yang akan menyimpan nilai final untuk kolom 'cabang_olahraga'

        Log::info('Store Method - Request Input:', $request->all());

        // Prioritas 1: Jika pemohon memilih 'lainnya' dan mengisi nama_mitra_baru (Membuat Mitra Baru)
        if ($validatedData['cabang_olahraga'] == 'lainnya' && !empty($validatedData['nama_mitra_baru'])) {
            $namaMitraBaru = $validatedData['nama_mitra_baru'];
            Log::info('Store Method - Handling "lainnya" option (New Mitra). namaMitraBaru: ' . $namaMitraBaru);

            $existingMitra = Mitra::where('nama', $namaMitraBaru)->first();

            if ($existingMitra) {
                Log::info('Store Method - Existing Mitra found. ID: ' . $existingMitra->id . ' Name: ' . $existingMitra->nama);
                $mitraId = $existingMitra->id;
                $cabangOlahragaForProposal = $existingMitra->nama;
            } else {
                Log::info('Store Method - Creating new Mitra. Name: ' . $namaMitraBaru);
                $mitra = new Mitra();
                $mitra->nama = $namaMitraBaru;
                $mitra->tipe = 'Non-Koni';
                $mitra->save();
                $mitraId = $mitra->id;
                $cabangOlahragaForProposal = $mitra->nama;
                Log::info('Store Method - New Mitra created. ID: ' . $mitra->id . ' Name: ' . $mitra->nama);
            }
        }
        // Prioritas 2: Jika pemohon memilih Mitra yang sudah ada (Format: "mitra-ID")
        elseif (Str::startsWith($validatedData['cabang_olahraga'], 'mitra-')) {
            $mitraString = $validatedData['cabang_olahraga']; // Contoh: "mitra-4"
            $mitraOnlyId = (int) Str::after($mitraString, 'mitra-'); // Mengambil ID saja, contoh: 4
            Log::info('Store Method - Handling existing Mitra ID string: ' . $mitraString . ', parsed ID: ' . $mitraOnlyId);

            $foundMitra = Mitra::find($mitraOnlyId);

            if ($foundMitra) {
                Log::info('Store Method - Existing Mitra found for ID: ' . $foundMitra->id . ' Name: ' . $foundMitra->nama);
                $mitraId = $foundMitra->id;
                $cabangOlahragaForProposal = $foundMitra->nama; // Simpan nama mitra di kolom `cabang_olahraga`
            } else {
                Log::warning('Store Method - Existing Mitra not found for ID: ' . $mitraOnlyId);
                // Redirect atau berikan error jika ID mitra tidak valid
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Pemohon terdaftar yang dipilih tidak valid.'])
                    ->withInput();
            }
        }
        // Prioritas 3: Jika pemohon memilih Cabang Olahraga dari daftar (ID numerik cabor)
        elseif (is_numeric($validatedData['cabang_olahraga'])) {
            $caborId = (int) $validatedData['cabang_olahraga'];
            Log::info('Store Method - Handling numeric cabor ID: ' . $caborId);

            $foundCabor = Cabor::where('api_cabor_id', $caborId)->first();

            if ($foundCabor) {
                Log::info('Store Method - Cabor found in local DB: ' . $foundCabor->nama_cabor);
                $cabangOlahragaForProposal = $foundCabor->api_cabor_id; // Simpan ID dari API cabor
            } else {
                Log::warning('Store Method - Numeric cabor ID not found in local DB: ' . $caborId);
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Cabang olahraga yang dipilih tidak valid atau tidak ditemukan di database lokal.'])
                    ->withInput();
            }
        }
        // Fallback: Jika 'cabang_olahraga' berisi string lain yang tidak teridentifikasi
        else {
            Log::info('Store Method - Handling direct string for cabang_olahraga (fallback): ' . $validatedData['cabang_olahraga']);
            $cabangOlahragaForProposal = $validatedData['cabang_olahraga'];
        }

        Log::info('Store Method - Final mitraId before Proposal create: ' . ($mitraId ?? 'NULL'));
        Log::info('Store Method - Final cabangOlahragaForProposal before Proposal create: ' . ($cabangOlahragaForProposal ?? 'NULL'));

        $jenisBerkas = implode(',', $validatedData['jenis_berkas']);

        $filePath = null;
        if ($request->hasFile('file_utama')) {
            $filePath = $request->file('file_utama')->store('proposals', 'public');
        }

        $proposal = Proposal::create([
            'user_id' => Auth::id(),
            'judul_berkas' => $validatedData['judul_berkas'],
            'pengaju' => $validatedData['pengaju'],
            'no_surat' => $validatedData['no_surat'],
            'perihal' => $validatedData['perihal'],
            'ringkasan_berkas' => $validatedData['ringkasan_berkas'],
            'tujuan_berkas' => $validatedData['tujuan_berkas'],
            'cabang_olahraga' => $cabangOlahragaForProposal,
            'no_telepon' => $validatedData['no_telepon'],
            'email' => $validatedData['email'],
            'alamat' => $validatedData['alamat'],
            'tgl_pengajuan' => $validatedData['tgl_pengajuan'],
            'file_utama' => $filePath,
            'nama_petugas' => $validatedData['nama_petugas'],
            'jabatan' => $validatedData['jabatan'],
            'jenis_berkas' => $jenisBerkas,
            'status' => 'diterima',
            'mitra_id' => $mitraId,
        ]);

        Log::info('Store Method - Proposal created. ID: ' . $proposal->id . ', Cabor: ' . $proposal->cabang_olahraga . ', Mitra ID: ' . ($proposal->mitra_id ?? 'NULL'));


        ProposalTrack::create([
            'proposal_id' => $proposal->id,
            'status_label' => 'Proposal diajukan dan diterima',
            'actor_id' => Auth::id(),
            'from_position' => null,
            'to_position' => strtolower(Auth::user()->role),
            'keterangan' => 'Proposal baru diajukan melalui sistem.',
            'is_current' => true,
        ]);

        Log::info('Store Method - ProposalTrack created for proposal ID: ' . $proposal->id);

        return redirect()->route('klien.proposal.data-proposal')->with('success', 'Proposal berhasil dikirim.');
    }


    public function show(string $id)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // Urutkan tracks dari yang paling lama ke yang terbaru
        $proposal = Proposal::with(['tracks' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'tracks.actorUser', 'mitra'])->findOrFail($id);

        $currentTrack = $proposal->currentTrack; // Dapatkan track terakhir yang aktif

        // --- Logika Akses Proposal (Akses ditolak jika tidak memiliki izin) ---
        if ($userRole !== 'superadmin') {
            $hasAccess = false;

            // Kondisi 1: Proposal saat ini berada di posisi user
            if ($currentTrack && $currentTrack->to_position === $userRole) {
                $hasAccess = true;
            }
            // Kondisi 2: User adalah pengaju proposal asli (misalnya Front Office yang pertama kali mengajukan)
            if ($proposal->user_id === $user->id) {
                $hasAccess = true;
            }
            // Kondisi 3: Role user pernah terlibat dalam riwayat proposal (from_position atau to_position, atau actor_id)
            if ($proposal->tracks->contains(function ($track) use ($userRole, $user) {
                return (strtolower($track->from_position) === $userRole || strtolower($track->to_position) === $userRole || $track->actor_id === $user->id);
            })) {
                $hasAccess = true;
            }

            if (!$hasAccess) {
                abort(403, 'Akses ditolak. Proposal ini tidak berada di posisi Anda saat ini, Anda bukan pengajunya, atau Anda tidak pernah terlibat dalam proses proposal ini.');
            }
        }
        // --- Akhir Logika Akses Proposal ---


        $currentPosition = $currentTrack ? $currentTrack->to_position : null;

        $allRoles = User::distinct()->pluck('role')->map(fn($role) => strtolower($role))->toArray();

        $trackedRoles = $proposal->tracks->pluck('from_position')
            ->merge($proposal->tracks->pluck('to_position'))
            ->filter()
            ->unique()
            ->map(fn($role) => strtolower($role))
            ->toArray();

        // Tentukan role yang tersedia untuk diteruskan
        $availableRolesToForwardTo = [];
        // Dropdown 'Diteruskan Kepada' hanya muncul jika status proposal BUKAN 'disetujui', 'ditolak', atau 'selesai'
        if (!in_array($proposal->status, ['disetujui', 'ditolak', 'selesai'])) {
            foreach ($allRoles as $role) {
                // Jangan tampilkan role user saat ini, role 'superadmin',
                // dan role yang sudah pernah terlibat dalam track proposal
                if ($role !== $userRole && $role !== 'superadmin' && !in_array($role, $trackedRoles)) {
                    $availableRolesToForwardTo[] = $role;
                }
            }
        }
        sort($availableRolesToForwardTo);

        $availableUsersForPositions = User::whereIn('role', $availableRolesToForwardTo)
            ->orderBy('name')
            ->get();

        // Logika untuk menentukan apakah user saat ini bisa mengubah status (untuk tombol 'Ubah Status')
        $canUpdateStatus = false;
        if ($userRole === 'superadmin') {
            $canUpdateStatus = true;
        } else {
            // User bisa ubah status jika proposal berada di posisinya DAN statusnya bukan final
            if ($currentTrack && $currentTrack->to_position === $userRole && !in_array($proposal->status, ['selesai', 'ditolak'])) {
                $canUpdateStatus = true;
            }
        }

        return view('Pages.Proposal.detail-proposal', compact('proposal', 'currentPosition', 'availableUsersForPositions', 'canUpdateStatus'));
    }

    // PROPOSAL KOTAK MASUK
    public function proposalTerbaru()
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        $proposals = Proposal::whereHas('currentTrack', function ($query) use ($userRole) {
            $query->where('to_position', $userRole);
        })
            ->whereIn('status', ['diterima'])
            ->orderBy('tgl_pengajuan', 'desc')
            ->with('mitra', 'currentTrack.actorUser')
            ->get();

        return view('Pages.Proposal.proposal-terbaru', compact('proposals'));
    }

    // FUNGSI UBAH STATUS
    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'posisiProposal' => 'nullable|string',
            'statusProposal' => 'required|string|in:diterima,diproses,disetujui,ditolak,pending,selesai',
            'keterangan' => 'nullable|string|max:255',
            'is_finished_action' => 'nullable|boolean',
        ]);

        $proposal = Proposal::findOrFail($id);
        $keterangan = $request->input('keterangan') ?? null;
        $selectedStatus = $request->input('statusProposal');
        $nextPositionInput = $request->input('posisiProposal');
        $actor = Auth::user();
        $actorRole = strtolower($actor->role);
        $nextPosition = (!empty($nextPositionInput) && strtolower($nextPositionInput) !== $actorRole) ? strtolower($nextPositionInput) : null;

        $lastTrack = $proposal->currentTrack;
        if ($lastTrack) {
            $lastTrack->update(['is_current' => false]);
        }

        $fromPosition = $lastTrack ? $lastTrack->to_position : $actorRole;

        $finalProposalStatusForModel = $selectedStatus; // Status default yang akan disimpan ke model Proposal
        $trackLabel = $this->getStatusLabel($selectedStatus); // Label untuk track baru
        $trackToPosition = $fromPosition; // Posisi tujuan default: tetap di posisi role saat ini

        // Case 1: Proposal ditandai selesai (tombol "Tandai Selesai" diklik)
        if ($request->boolean('is_finished_action')) {
            $proposal->is_finished = true; // Set flag is_finished menjadi true
            $trackToPosition = null; // Tidak ada penerusan lagi jika sudah selesai

            if ($selectedStatus === 'ditolak') {
                $finalProposalStatusForModel = 'ditolak';
                $trackLabel = 'Proposal Ditolak Secara Final';
                $keterangan = $keterangan ?? 'Proposal ditolak dan proses dinyatakan selesai.';
            } elseif ($selectedStatus === 'disetujui' || $selectedStatus === 'diproses') {
                $finalProposalStatusForModel = 'selesai';
                $trackLabel = 'Proposal Disetujui dan Proses Selesai';
                $keterangan = $keterangan ?? 'Proposal telah disetujui dan proses selesai.';
            } else {
                $finalProposalStatusForModel = 'selesai';
                $trackLabel = 'Proses Proposal Selesai (Manual)';
                $keterangan = $keterangan ?? 'Proses proposal telah diselesaikan secara manual.';
            }
        }

        // Case 2: Proposal diteruskan ke posisi role yang BERBEDA
        elseif ($nextPosition) { // Kondisi ini sekarang secara benar memfilter penerusan ke diri sendiri
            $proposal->is_finished = false;

            if ($selectedStatus === 'pending') {
                $finalProposalStatusForModel = 'pending'; // Jika diteruskan dengan status pending (misal: untuk revisi)
            } else {
                $finalProposalStatusForModel = 'diterima'; // Jika diteruskan (selain pending), masuk ke inbox baru dengan status diterima
            }

            // Track menuju posisi baru
            $trackToPosition = $nextPosition;

            if ($selectedStatus === 'pending' && $nextPosition === 'frontoffice') {
                $trackLabel = 'Proposal Dikembalikan untuk Revisi oleh ' . ucfirst($actorRole);
                $keterangan = $keterangan ?? 'Proposal dikembalikan untuk revisi ke Front Office.';
            } else {
                $actionLabel = $this->getStatusLabel($selectedStatus);
                $trackLabel = $actionLabel . ' dan Diteruskan ke ' . ucfirst($nextPosition);
                $keterangan = $keterangan ?? 'Proposal diteruskan dari ' . ucfirst($actorRole) . ' ke ' . ucfirst($nextPosition) . '.';
            }
        }

        // Case 3: Perubahan status internal di role saat ini (tidak ada penerusan ATAU penerusan ke diri sendiri)
        else {
            $proposal->is_finished = false;
            $finalProposalStatusForModel = $selectedStatus;
            $trackToPosition = $fromPosition;
            $trackLabel = $this->getStatusLabel($selectedStatus) . ' oleh ' . ucfirst($actorRole);
            $keterangan = $keterangan ?? 'Status proposal diubah oleh ' . ucfirst($actorRole) . '.';

            // Penanganan khusus jika status saat ini menjadi 'diterima'
            if ($selectedStatus === 'diterima') {
                // Jika secara eksplisit diatur ke 'diterima' di role yang sama, ini seperti pembukaan kembali atau penandaan sebagai baru
                $trackLabel = 'Proposal ' . ucfirst($selectedStatus) . ' oleh ' . ucfirst($actorRole);
                $keterangan = $keterangan ?? 'Proposal kembali ke status diterima di posisi ' . ucfirst($actorRole) . '.';
            }
        }

        $proposal->status = $finalProposalStatusForModel;
        $proposal->save();

        // Buat entri baru di ProposalTrack
        ProposalTrack::create([
            'proposal_id' => $proposal->id,
            'status_label' => $trackLabel,
            'actor_id' => $actor->id,
            'from_position' => $fromPosition,
            'to_position' => $trackToPosition,
            'keterangan' => $keterangan,
            'is_current' => true, // Tandai track ini sebagai track aktif/terkini
        ]);


        return redirect()->route('superadmin.proposal.show', $proposal->id)->with('success', 'Status proposal berhasil diubah.');
    }

    // STATUS YANG TERSEDIA
    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Menunggu Persetujuan / Dikembalikan untuk Revisi',
            'diterima' => 'Proposal Diterima',
            'diproses' => 'Proposal Sedang Diproses',
            'disetujui' => 'Proposal Disetujui',
            'ditolak' => 'Proposal Ditolak',
            'selesai' => 'Proses Proposal Selesai',
            default => 'Status Tidak Diketahui',
        };
    }

    // FUNGSI SURAT TANDA TERIMA
    public function tandaTerima($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('Pages.Proposal.tanda-terima', compact('proposal'));
    }

    // FUNGSI TRACKING PUBLIC
    public function trackingPublic($id)
    {
        $proposal = Proposal::with('tracks.actorUser')->findOrFail($id);
        $currentTrack = $proposal->currentTrack;
        $currentPosition = $currentTrack ? $currentTrack->to_position : null;

        return view('Pages.Tracking.tracking-public', compact('proposal', 'currentPosition'));
    }

    // FUNGSI EXPORT CSV
    public function exportCsv()
    {
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=proposals_" . Carbon::now()->format('Ymd_His') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $proposals = Proposal::all();
        $columns = [
            'No',
            'Status',
            'No surat',
            'Perihal',
            'Judul',
            'Berupa',
            'Nama Pengaju',
            'Cabor/Pemohon',
            'Tgl Pengajuan',
            'Petugas'
        ];

        $callback = function () use ($proposals, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $i = 1;
            foreach ($proposals as $proposal) {
                $row = [
                    $i++,
                    $proposal->status,
                    $proposal->no_surat,
                    $proposal->perihal,
                    $proposal->judul_berkas,
                    $proposal->jenis_berkas,
                    $proposal->pengaju,
                    $proposal->nama_cabor,
                    Carbon::parse($proposal->tgl_pengajuan)->format('d M Y'),
                    $proposal->nama_petugas,
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
