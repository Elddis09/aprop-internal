<?php

namespace App\Http\Controllers;

use App\Helpers\RoleFormatter;
use App\Models\Mitra;
use App\Models\Proposal;
use App\Models\ProposalTrack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ProposalPdfGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Cabor;
use Illuminate\Support\Facades\Storage;
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
                    ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pengaju', 'like', '%' . $searchTerm . '%');
            });
        }

        $proposals = $query->whereHas('tracks', function ($q) use ($userRole) {
            $q->where('to_position', $userRole);
        })
            ->where('status', '!=', 'dibatalkan')
            ->with('mitra', 'currentTrack.actorUser')
            ->latest()
            ->paginate(10);
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
            'stafbinpres',
            'bidangumum',
            'sekretaristiga',
            'ketuatiga',
            'stafumum',
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
                    ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pengaju', 'like', '%' . $searchTerm . '%');
            });
        }


        $proposals = $query->with('mitra', 'currentTrack.actorUser')->latest()->paginate(10);

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
        // Validasi data input dari form
        $validatedData = $request->validate([
            'judul_berkas' => 'nullable|string|max:255',
            'pengaju' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_berkas' => 'required|array',
            'jenis_berkas.*' => 'in:surat,proposal,barang', // Memastikan jenis berkas valid
            'pengcab' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'cabang_olahraga' => 'required|string', // Bisa ID cabor, 'mitra-ID', atau 'lainnya'
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'tgl_pengajuan' => 'required|date',
            'file_utama' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Maksimal 5MB
            'nama_petugas' => 'required|string|max:255',
            'nama_mitra_baru' => [ // Wajib diisi jika 'cabang_olahraga' adalah 'lainnya'
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cabang_olahraga') == 'lainnya';
                }),
            ],
        ]);

        $mitraId = null; // Akan menyimpan ID Mitra jika dipilih
        $cabangOlahragaForProposal = null; // Akan menyimpan nilai final untuk kolom 'cabang_olahraga' di tabel proposal

        // Log input request untuk debugging
        Log::info('Store Method - Request Input:', $request->all());

        // Logika untuk menentukan nilai 'cabang_olahraga' dan 'mitra_id' yang akan disimpan

        // Prioritas 1: Jika pemohon memilih 'lainnya' dan mengisi nama_mitra_baru (Membuat Mitra Baru)
        if ($validatedData['cabang_olahraga'] == 'lainnya' && !empty($validatedData['nama_mitra_baru'])) {
            $namaMitraBaru = $validatedData['nama_mitra_baru'];
            Log::info('Store Method - Menangani opsi "lainnya" (Mitra Baru). Nama Mitra Baru: ' . $namaMitraBaru);

            // Cek apakah mitra dengan nama tersebut sudah ada
            $existingMitra = Mitra::where('nama', $namaMitraBaru)->first();

            if ($existingMitra) {
                // Jika sudah ada, gunakan mitra yang ada
                Log::info('Store Method - Mitra sudah ada. ID: ' . $existingMitra->id . ' Nama: ' . $existingMitra->nama);
                $mitraId = $existingMitra->id;
                $cabangOlahragaForProposal = $existingMitra->nama; // Simpan nama mitra di kolom `cabang_olahraga`
            } else {
                // Jika belum ada, buat mitra baru
                Log::info('Store Method - Membuat Mitra baru. Nama: ' . $namaMitraBaru);
                $mitra = new Mitra();
                $mitra->nama = $namaMitraBaru;
                $mitra->tipe = 'Non-Koni'; // Atur tipe mitra, sesuaikan jika ada tipe lain
                $mitra->save();
                $mitraId = $mitra->id;
                $cabangOlahragaForProposal = $mitra->nama; // Simpan nama mitra di kolom `cabang_olahraga`
                Log::info('Store Method - Mitra baru dibuat. ID: ' . $mitra->id . ' Nama: ' . $mitra->nama);
            }
        }
        // Prioritas 2: Jika pemohon memilih Mitra yang sudah ada dari daftar (Format: "mitra-ID")
        elseif (Str::startsWith($validatedData['cabang_olahraga'], 'mitra-')) {
            $mitraString = $validatedData['cabang_olahraga']; // Contoh: "mitra-4"
            $mitraOnlyId = (int) Str::after($mitraString, 'mitra-'); // Mengambil ID numerik saja, contoh: 4
            Log::info('Store Method - Menangani string ID Mitra yang sudah ada: ' . $mitraString . ', ID yang diurai: ' . $mitraOnlyId);

            $foundMitra = Mitra::find($mitraOnlyId);

            if ($foundMitra) {
                // Jika mitra ditemukan, gunakan ID dan namanya
                Log::info('Store Method - Mitra ditemukan berdasarkan ID: ' . $foundMitra->id . ' Nama: ' . $foundMitra->nama);
                $mitraId = $foundMitra->id;
                $cabangOlahragaForProposal = $foundMitra->nama; // Simpan nama mitra di kolom `cabang_olahraga`
            } else {
                // Jika ID mitra tidak valid
                Log::warning('Store Method - Mitra tidak ditemukan untuk ID: ' . $mitraOnlyId);
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Pemohon terdaftar yang dipilih tidak valid.'])
                    ->withInput();
            }
        }
        // Prioritas 3: Jika pemohon memilih Cabang Olahraga dari daftar API (nilai numerik api_cabor_id)
        elseif (is_numeric($validatedData['cabang_olahraga'])) {
            $caborId = (int) $validatedData['cabang_olahraga'];
            Log::info('Store Method - Menangani ID cabor numerik: ' . $caborId);

            // Cari cabang olahraga di database lokal berdasarkan api_cabor_id
            $foundCabor = Cabor::where('api_cabor_id', $caborId)->first();

            if ($foundCabor) {
                Log::info('Store Method - Cabor ditemukan di DB lokal: ' . $foundCabor->nama_cabor);
                // INI PERUBAHAN UTAMA: SIMPAN NAMA CABANG OLAHRAGA BUKAN ID-NYA
                $cabangOlahragaForProposal = $foundCabor->nama_cabor; // <-- UBAH KE NAMA CABOR
            } else {
                // Jika ID cabor tidak ditemukan di database lokal
                Log::warning('Store Method - ID cabor numerik tidak ditemukan di DB lokal: ' . $caborId);
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Cabang olahraga yang dipilih tidak valid atau tidak ditemukan di database lokal.'])
                    ->withInput();
            }
        }
        // Fallback: Jika 'cabang_olahraga' berisi string lain yang tidak teridentifikasi
        else {
            Log::info('Store Method - Menangani string langsung untuk cabang_olahraga (fallback): ' . $validatedData['cabang_olahraga']);
            $cabangOlahragaForProposal = $validatedData['cabang_olahraga'];
        }

        // Log nilai akhir sebelum menyimpan proposal
        Log::info('Store Method - Final mitraId sebelum membuat Proposal: ' . ($mitraId ?? 'NULL'));
        Log::info('Store Method - Final cabangOlahragaForProposal sebelum membuat Proposal: ' . ($cabangOlahragaForProposal ?? 'NULL'));

        // Menggabungkan array jenis_berkas menjadi string koma-terpisah
        $jenisBerkas = implode(',', $validatedData['jenis_berkas']);

        // Mengunggah file utama jika ada
        $filePath = null;
        if ($request->hasFile('file_utama')) {
            $filePath = $request->file('file_utama')->store('proposals', 'public');
        }

        // Membuat entri Proposal baru di database
        $proposal = Proposal::create([
            'user_id' => Auth::id(), // ID pengguna yang sedang login
            'judul_berkas' => $validatedData['judul_berkas'] ?? '',
            'pengaju' => $validatedData['pengaju'],
            'no_surat' => $validatedData['no_surat'],
            'tgl_surat' => $validatedData['tgl_surat'],
            'perihal' => $validatedData['perihal'],
            'pengcab' => $validatedData['pengcab'],
            'agenda_number' => null, // Atur jika ada logika generate nomor agenda
            'cabang_olahraga' => $cabangOlahragaForProposal, // Menggunakan nilai yang sudah ditentukan di atas
            'no_telepon' => $validatedData['no_telepon'],
            'email' => $validatedData['email'] ?? '', // Gunakan null coalescing operator untuk default string kosong
            'alamat' => $validatedData['alamat'],
            'tgl_pengajuan' => $validatedData['tgl_pengajuan'],
            'file_utama' => $filePath,
            'nama_petugas' => $validatedData['nama_petugas'],
            'jabatan' => $validatedData['jabatan'],
            'jenis_berkas' => $jenisBerkas,
            'status' => 'diterima', // Status awal proposal
            'mitra_id' => $mitraId, // Menggunakan ID Mitra yang sudah ditentukan di atas
        ]);

        // Log informasi proposal yang baru dibuat
        Log::info('Store Method - Proposal berhasil dibuat. ID: ' . $proposal->id . ', Cabor: ' . $proposal->cabang_olahraga . ', Mitra ID: ' . ($proposal->mitra_id ?? 'NULL') . ', Agenda Number: ' . ($proposal->agenda_number ?? 'NULL'));

        // Membuat entri di ProposalTrack untuk melacak status proposal
        ProposalTrack::create([
            'proposal_id' => $proposal->id,
            'status_label' => 'Proposal diajukan dan diterima',
            'actor_id' => Auth::id(),
            'from_position' => null, // Posisi awal
            'to_position' => strtolower(Auth::user()->role), // Posisi saat ini (role pengguna)
            'keterangan' => 'Proposal baru diajukan melalui sistem.',
            'is_current' => true, // Menandakan ini adalah status terakhir
        ]);

        Log::info('Store Method - ProposalTrack berhasil dibuat untuk proposal ID: ' . $proposal->id);

        // Redirect ke halaman daftar proposal klien dengan pesan sukses
        return redirect()->route('klien.proposal.data-proposal')->with('success', 'Proposal berhasil dikirim.');
    }

    public function generateAgendaNumber(Request $request, $proposalId)
    {
        $proposal = Proposal::find($proposalId);

        if (!$proposal) {
            return response()->json(['message' => 'Proposal tidak ditemukan'], 404);
        }

        // Pastikan nomor agenda belum terisi agar tidak digenerate ulang
        if ($proposal->agenda_number !== null) {
            return response()->json(['message' => 'Nomor agenda sudah digenerate untuk proposal ini'], 400);
        }

        // Panggil fungsi logika yang sudah disesuaikan untuk string
        $nextAgendaNumber = $this->generateNextAgendaNumberLogic();
        Log::info('Generated Agenda Number for Proposal ' . $proposal->id . ': ' . $nextAgendaNumber);

        $proposal->agenda_number = $nextAgendaNumber;
        $proposal->save();



        return response()->json([
            'message' => 'Nomor agenda berhasil digenerate!',
            'agenda_number' => $nextAgendaNumber
        ]);
    }

    /**
     * Fungsi logika untuk menghasilkan nomor agenda berikutnya (sebagai string numerik).
     * Akan mengurutkan secara numerik meskipun kolomnya string.
     */
    private function generateNextAgendaNumberLogic(): string // Mengembalikan string
    {
        // Ambil proposal terakhir berdasarkan nomor agenda tertinggi,
        // dengan meng-CAST string ke UNSIGNED INTEGER SAAT ORDERING.
        $lastProposal = Proposal::whereNotNull('agenda_number')
            ->orderByRaw('CAST(agenda_number AS UNSIGNED) DESC') // Ini kunci untuk pengurutan numerik pada string
            ->first();

        $nextNumber = 500; // Nomor awal jika belum ada data atau data di bawah 500

        if ($lastProposal && is_numeric($lastProposal->agenda_number)) { // Pastikan nilai yang diambil benar-benar angka
            $lastNumericAgenda = (int)$lastProposal->agenda_number;
            if ($lastNumericAgenda >= 500) {
                $nextNumber = $lastNumericAgenda + 1;
            }
        }

        return (string) $nextNumber; // Pastikan mengembalikan string
    }
    public function show(string $id)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // Urutkan tracks dari yang paling lama ke yang terbaru
        $proposal = Proposal::with(['tracks' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'tracks.actorUser', 'mitra', 'dataUpdatedByUser'])->findOrFail($id);

        $currentTrack = $proposal->currentTrack; // Dapatkan track terakhir yang aktif

        // --- Logika Akses Proposal (Akses ditolak jika tidak memiliki izin) ---
        if ($userRole !== 'superadmin' && $userRole !== 'ketuaumum') {
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
        $isBackoffice = in_array($userRole, ['backoffice', 'superadmin']);
        return view('Pages.Proposal.detail-proposal', compact('proposal', 'currentPosition', 'availableUsersForPositions', 'canUpdateStatus'));
    }

    // PROPOSAL KOTAK MASUK
    public function proposalTerbaru(Request $request)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // Inisialisasi query builder
        $query = Proposal::query();

        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_surat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                    ->orWhere('judul_berkas', 'like', '%' . $searchTerm . '%')
                    ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pengaju', 'like', '%' . $searchTerm . '%');
            });
        }

        // Terapkan semua kondisi dan eager loading ke objek query builder
        $query->whereHas('currentTrack', function ($q) use ($userRole) {
            $q->where('to_position', $userRole);
        })
            ->whereIn('status', ['diterima'])
            ->orderBy('tgl_pengajuan', 'desc')
            ->orderBy('created_at', 'desc')
            ->with('mitra', 'currentTrack.actorUser');

        // Lakukan pagination pada objek query builder
        $proposals = $query->paginate(10);

        $proposals->appends(request()->except('page'));

        return view('Pages.Proposal.proposal-terbaru', compact('proposals'));
    }

    // FUNGSI UBAH STATUS
    public function ubahStatus(Request $request, $id)
    {
        $actor = Auth::user();
        $actorRole = strtolower($actor->role);

        Log::info('--- ubahStatus START (Original Code Debug) ---');
        Log::info('Actor Role: ' . $actorRole);
        Log::info('Request All Data: ' . json_encode($request->all())); // Pastikan ini aktif!

        $validationRules = [
            'posisiProposal' => 'nullable|string',
            'status' => 'required|string|in:diterima,diproses,disetujui,ditolak,pending,selesai,cancel',
            'keterangan' => 'nullable|string|max:255',
            'is_finished_action' => 'nullable|boolean',
        ];

        $canEditKategori = in_array($actorRole, ['backoffice', 'superadmin']);
        Log::info('Can Edit Kategori (di controller): ' . ($canEditKategori ? 'true' : 'false'));

        if ($canEditKategori) {
            $validationRules['kategoriBerkas'] = 'nullable|string|in:undangan,peminjaman,BantuanDana,lainnya';
        } else {
            $validationRules['kategoriBerkas'] = 'nullable|string';
        }

        $request->validate($validationRules);

        $proposal = Proposal::findOrFail($id);
        $keterangan = $request->input('keterangan') ?? null;
        $selectedStatus = $request->input('status'); // Status yang dipilih dari dropdown
        $nextPositionInput = $request->input('posisiProposal');
        $isFinishedAction = $request->boolean('is_finished_action'); // Ambil dari request


        if ($canEditKategori) {
            Log::info('Mencoba update kategoriBerkas. Nilai dari request: ' . ($request->input('kategoriBerkas') ?? 'NULL'));
            $proposal->kategoriBerkas = $request->input('kategoriBerkas');
            Log::info('Nilai kategoriBerkas pada objek proposal setelah assignment: ' . ($proposal->kategoriBerkas ?? 'NULL'));
        } else {
            Log::info('Kategori Berkas TIDAK diupdate karena user tidak memiliki izin.');
        }

        $nextPosition = (!empty($nextPositionInput) && strtolower($nextPositionInput) !== $actorRole) ? strtolower($nextPositionInput) : null;
        Log::info('Calculated Next Position for forwarding: ' . ($nextPosition ?? 'NULL (internal change or same role)'));

        $lastTrack = $proposal->currentTrack;
        if ($lastTrack) {
            $lastTrack->update(['is_current' => false]);
            Log::info('Previous track marked as not current: ' . $lastTrack->id);
        }

        $fromPosition = $lastTrack ? $lastTrack->to_position : $actorRole;
        Log::info('From Position for new track: ' . $fromPosition);

        $finalProposalStatusForModel = $selectedStatus; // Status default, akan diubah oleh logika di bawah
        $trackLabel = $this->getStatusLabel($selectedStatus);
        $trackToPosition = $fromPosition; // Default: tetap di posisi aktor saat ini
        $proposal->is_finished = false; // Default

        Log::info('Initial State: finalStatus=' . $finalProposalStatusForModel . ', trackTo=' . ($trackToPosition ?? 'NULL') . ', isFinished=' . ($proposal->is_finished ? 'true' : 'false'));

        // --- Start Logic for Status Changes ---

        // Case 1: Proposal Dicancel atau Ditolak (Final)
        if ($selectedStatus === 'cancel' || $selectedStatus === 'ditolak') {
            $proposal->is_finished = true;
            $finalProposalStatusForModel = $selectedStatus;
            $trackLabel = 'Proposal ' . ucfirst($selectedStatus) . ' Secara Final oleh ' . $this->formatRoleName($actorRole);
            $keterangan = $keterangan ?? 'Proposal ' . $selectedStatus . ' dan proses dinyatakan selesai oleh ' . $this->formatRoleName($actorRole) . '.';
            $trackToPosition = null; // Tidak ada penerusan lagi
            Log::info('Logic Branch: Finalized (Cancel/Ditolak)');
        }
        // Case 2: Proposal ditandai selesai (menggunakan tombol is_finished_action)
        elseif ($isFinishedAction) { // Ini harusnya prioritas jika tombol "selesai" diklik
            $proposal->is_finished = true;
            $trackToPosition = null; // Tidak ada penerusan lagi

            // Jika status di dropdown adalah 'ditolak' saat 'selesai' diklik
            if ($selectedStatus === 'ditolak') {
                $finalProposalStatusForModel = 'ditolak';
                $trackLabel = 'Proposal Ditolak Secara Final (Melalui Tandai Selesai)';
                $keterangan = $keterangan ?? 'Proposal ditolak dan proses dinyatakan selesai.';
            }
            // Jika status di dropdown adalah 'disetujui' atau 'diproses' saat 'selesai' diklik
            elseif ($selectedStatus === 'disetujui' || $selectedStatus === 'diproses') {
                $finalProposalStatusForModel = 'selesai'; // Jadi 'selesai' di database
                $trackLabel = 'Proposal ' . ucfirst($selectedStatus) . ' dan Proses Selesai';
                $keterangan = $keterangan ?? 'Proposal telah ' . $selectedStatus . ' dan proses diselesaikan.';
            }
            // Kasus lain saat tombol 'selesai' diklik
            else {
                $finalProposalStatusForModel = 'selesai';
                $trackLabel = 'Proses Proposal Selesai (Manual)';
                $keterangan = $keterangan ?? 'Proses proposal telah diselesaikan secara manual.';
            }
            Log::info('Logic Branch: Is Finished Action Triggered');
        }
        // Case 3: Proposal diteruskan ke posisi role yang BERBEDA
        // (nextPosition bernilai bukan null, berarti ada role yang berbeda dipilih)
        elseif ($nextPosition) {
            $proposal->is_finished = false; // Belum selesai, sedang diteruskan

            // *** PERBAIKAN PENTING DI SINI ***
            if ($selectedStatus === 'disetujui') {
                // Sesuai permintaan: jika status 'disetujui' DAN diteruskan, maka jadi 'diterima' di penerima.
                $finalProposalStatusForModel = 'diterima';
                $trackLabel = 'Proposal Disetujui dan Diteruskan ke ' . $this->formatRoleName($nextPosition);
                $keterangan = $keterangan ?? 'Proposal telah disetujui dan diteruskan ke ' . $this->formatRoleName($nextPosition);
                Log::info('Logic Branch: Forwarded (Approved, becomes Diterima)');
            } elseif ($selectedStatus === 'pending' && $nextPosition === 'frontoffice') {
                // Kasus khusus: dikembalikan untuk revisi ke Front Office
                $finalProposalStatusForModel = 'pending';
                $trackLabel = 'Proposal Dikembalikan untuk Revisi oleh ' . $this->formatRoleName($actorRole);
                $keterangan = $keterangan ?? 'Proposal dikembalikan untuk revisi ke Front Office.';
                Log::info('Logic Branch: Forwarded (Pending to Frontoffice)');
            } else {
                // Untuk semua status lain (termasuk 'diproses') saat diteruskan ke posisi berbeda,
                // status di model akan sama dengan selectedStatus.
                $finalProposalStatusForModel = $selectedStatus;
                $actionLabel = $this->getStatusLabel($selectedStatus);
                $trackLabel = $actionLabel . ' dan Diteruskan ke ' . $this->formatRoleName($nextPosition);
                $keterangan = $keterangan ?? 'Proposal diteruskan dari ' . $this->formatRoleName($actorRole) . ' ke ' . $this->formatRoleName($nextPosition) . '.';
                Log::info('Logic Branch: Forwarded (Status Maintained)');
            }
            $trackToPosition = $nextPosition; // Target posisi untuk track baru
        }
        // Case 4: Perubahan status internal di role saat ini
        // (nextPosition adalah null, artinya tidak diteruskan ke role berbeda,
        // dan juga bukan aksi finalisasi/selesai manual)
        else {
            $proposal->is_finished = false;
            $finalProposalStatusForModel = $selectedStatus; // Status di model akan sesuai pilihan dropdown
            $trackToPosition = $fromPosition; // Tetap di posisi aktor saat ini

            $trackLabel = $this->getStatusLabel($selectedStatus) . ' oleh ' . $this->formatRoleName($actorRole);
            $keterangan = $keterangan ?? 'Status proposal diubah oleh ' . $this->formatRoleName($actorRole) . '.';

            // Penanganan khusus jika status kembali menjadi 'diterima' (misal: dibuka kembali)
            if ($selectedStatus === 'diterima') {
                $trackLabel = 'Proposal ' . ucfirst($selectedStatus) . ' oleh ' . $this->formatRoleName($actorRole);
                $keterangan = $keterangan ?? 'Proposal kembali ke status diterima di posisi ' . $this->formatRoleName($actorRole) . '.';
            }
            Log::info('Logic Branch: Internal Status Change (No Forward)');
        }

        // --- End Logic for Status Changes ---

        // Set status pada model proposal sebelum menyimpan
        $proposal->status = $finalProposalStatusForModel;

        Log::info('Final proposal->status BEFORE SAVE: ' . $proposal->status);
        Log::info('Final proposal->is_finished BEFORE SAVE: ' . ($proposal->is_finished ? 'true' : 'false'));
        Log::info('Final Track Label: ' . $trackLabel);
        Log::info('Final Track From Position: ' . $fromPosition);
        Log::info('Final Track To Position: ' . ($trackToPosition ?? 'NULL'));

        // $proposal->data_updated_at = now();
        // $proposal->data_updated_by_user_id = $actor->id;
        $proposal->save();
        Log::info('Proposal saved successfully. New status in DB: ' . $proposal->status);

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
        Log::info('New ProposalTrack created.');

        Log::info('--- ubahStatus END ---');

        return redirect()->route('superadmin.proposal.show', $proposal->id)->with('success', 'Status proposal berhasil diubah.');
    }

    private function formatRoleName($role)
    {
        return RoleFormatter::format($role);
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
            'cancel' => 'Proposal Dicancel',
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
            'No Agenda',
            'No surat',
            'Kategori',
            'Tgl_surat',
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
                    $proposal->agenda_number,
                    $proposal->no_surat,
                    $proposal->kategoriBerkas,
                    $proposal->tgl_surat,
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

    public function disposisi($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('Pages.Proposal.disposisi', compact('proposal'));
    }
    public function formCeklis($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('Pages.Proposal.form-ceklis', compact('proposal'));
    }
    public function formUndangan($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('Pages.Proposal.form-undangan', compact('proposal'));
    }
    public function formPeminjaman($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('Pages.Proposal.form-peminjaman', compact('proposal'));
    }
    public function edit($id)
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);
        $proposal = Proposal::with(['tracks' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'tracks.actorUser', 'mitra'])->findOrFail($id);

        $currentTrack = $proposal->currentTrack;

        if ($userRole !== 'superadmin' && $userRole !== 'ketuaumum') {
            $hasAccess = false;

            if ($currentTrack && $currentTrack->to_position === $userRole) {
                $hasAccess = true;
            }
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

        $proposal = Proposal::findOrFail($id);

        $caborData = Cabor::all();
        $mitras = Mitra::all();
        return view('Pages.Proposal.update-proposal', compact('proposal', 'caborData', 'mitras'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validatedData = $request->validate([
            'judul_berkas' => 'nullable|string|max:255',
            'pengaju' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_berkas' => 'required|array',
            'jenis_berkas.*' => 'in:surat,proposal,barang',
            'pengcab' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'cabang_olahraga' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'nama_petugas' => 'required|string|max:255',
            'tgl_pengajuan' => 'required|date',
            'file_utama' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'nama_mitra_baru' => [ // Variabel ini sebelumnya 'nama_mitra_baru'
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('cabang_olahraga') == 'lainnya';
                }),
            ],
        ]);

        $mitraId = null;
        $cabangOlahragaForProposal = null;

        $userLoggedInId = Auth::id(); // Ambil ID user yang login saat ini
        Log::info('DEBUG INFO: User ID yang sedang login: ' . $userLoggedInId);
        Log::info('Update Method - Request Input:', $request->all());

        // Logika sama persis seperti di store method untuk menentukan mitra_id dan cabang_olahraga
        if ($validatedData['cabang_olahraga'] == 'lainnya' && !empty($validatedData['nama_mitra_baru'])) {
            $namaMitraBaru = $validatedData['nama_mitra_baru'];
            Log::info('Update Method - Handling "lainnya" option (New Mitra). namaMitraBaru: ' . $namaMitraBaru);

            $existingMitra = Mitra::where('nama', $namaMitraBaru)->first();

            if ($existingMitra) {
                Log::info('Update Method - Existing Mitra found. ID: ' . $existingMitra->id);
                $mitraId = $existingMitra->id;
                $cabangOlahragaForProposal = $existingMitra->nama;
            } else {
                Log::info('Update Method - Creating new Mitra. Name: ' . $namaMitraBaru);
                $mitra = new Mitra();
                $mitra->nama = $namaMitraBaru;
                $mitra->tipe = 'Non-Koni';
                $mitra->save();
                $mitraId = $mitra->id;
                $cabangOlahragaForProposal = $mitra->nama;
                Log::info('Update Method - New Mitra created. ID: ' . $mitra->id);
            }
        } elseif (Str::startsWith($validatedData['cabang_olahraga'], 'mitra-')) {
            $mitraString = $validatedData['cabang_olahraga'];
            $mitraOnlyId = (int) Str::after($mitraString, 'mitra-');
            Log::info('Update Method - Handling existing Mitra ID string: ' . $mitraString . ', parsed ID: ' . $mitraOnlyId);

            $foundMitra = Mitra::find($mitraOnlyId);

            if ($foundMitra) {
                Log::info('Update Method - Existing Mitra found for ID: ' . $foundMitra->id);
                $mitraId = $foundMitra->id;
                $cabangOlahragaForProposal = $foundMitra->nama;
            } else {
                Log::warning('Update Method - Existing Mitra not found for ID: ' . $mitraOnlyId);
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Pemohon terdaftar yang dipilih tidak valid.'])
                    ->withInput();
            }
        } elseif (is_numeric($validatedData['cabang_olahraga'])) {
            $caborId = (int) $validatedData['cabang_olahraga'];
            Log::info('Update Method - Handling numeric cabor ID: ' . $caborId);

            $foundCabor = Cabor::where('api_cabor_id', $caborId)->first();

            if ($foundCabor) {
                Log::info('Update Method - Cabor found in local DB: ' . $foundCabor->nama_cabor);
                // INI YANG DIUBAH DI UPDATE METHOD: Simpan NAMA cabor
                $cabangOlahragaForProposal = $foundCabor->nama_cabor;
            } else {
                Log::warning('Update Method - Numeric cabor ID not found in local DB: ' . $caborId);
                return redirect()->back()
                    ->withErrors(['cabang_olahraga' => 'Cabang olahraga yang dipilih tidak valid atau tidak ditemukan di database lokal.'])
                    ->withInput();
            }
        } else {
            Log::info('Update Method - Handling direct string for cabang_olahraga (fallback): ' . $validatedData['cabang_olahraga']);
            $cabangOlahragaForProposal = $validatedData['cabang_olahraga'];
        }

        Log::info('Update Method - Final mitraId before Proposal update: ' . ($mitraId ?? 'NULL'));
        Log::info('Update Method - Final cabangOlahragaForProposal before Proposal update: ' . ($cabangOlahragaForProposal ?? 'NULL'));

        $jenisBerkas = implode(',', $validatedData['jenis_berkas']);

        // Handle file update
        if ($request->hasFile('file_utama')) {
            if ($proposal->file_utama) {
                Storage::disk('public')->delete($proposal->file_utama);
            }
            $filePath = $request->file('file_utama')->store('proposals', 'public');
        } else {
            $filePath = $proposal->file_utama;
        }

        // >>> PERBAIKI BAGIAN INI: TAMBAHKAN 'user_id' KE DALAM ARRAY UPDATE
        $proposal->update([
            'judul_berkas' => $validatedData['judul_berkas'] ?? '',
            'pengaju' => $validatedData['pengaju'],
            'no_surat' => $validatedData['no_surat'],
            'tgl_surat' => $validatedData['tgl_surat'],
            'perihal' => $validatedData['perihal'],
            'pengcab' => $validatedData['pengcab'],
            'cabang_olahraga' => $cabangOlahragaForProposal,
            'no_telepon' => $validatedData['no_telepon'],
            'email' => $validatedData['email'] ?? '',
            'alamat' => $validatedData['alamat'],
            'tgl_pengajuan' => $validatedData['tgl_pengajuan'],
            'file_utama' => $filePath,
            'nama_petugas' => $validatedData['nama_petugas'],
            'jabatan' => $validatedData['jabatan'],
            'jenis_berkas' => $jenisBerkas,
            'mitra_id' => $mitraId,
            'user_id' => $userLoggedInId,
            'data_updated_at' => Carbon::now(),
            'data_updated_by_user_id' => Auth::id(),
        ]);

        Log::info('DEBUG INFO: Proposal successfully updated. Updated user_id in DB should be: ' . $userLoggedInId);
        Log::info('Update Method - Proposal updated. ID: ' . $proposal->id . ', Cabor: ' . $proposal->cabang_olahraga . ', Mitra ID: ' . ($proposal->mitra_id ?? 'NULL'));

        return redirect()->route('klien.proposal.data-proposal')->with('success', 'Proposal berhasil diperbarui.');
    }
}
