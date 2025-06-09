<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalTrack;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProposalController extends Controller
{
    // Menampilkan semua proposal milik user login (klien)
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Proposal::query();

        $searchTerm = $request->input('search');

        if ($searchTerm) {
            // Lakukan pencarian berdasarkan kolom yang relevan
            $query->where('no_surat', 'like', '%' . $searchTerm . '%')
                ->orWhere('perihal', 'like', '%' . $searchTerm . '%')
                ->orWhere('judul_berkas', 'like', '%' . $searchTerm . '%')
                ->orWhere('cabang_olahraga', 'like', '%' . $searchTerm . '%'); // Sesuaikan dengan nama kolom Cabor di database Anda
        }

        // Role yang bisa melihat semua proposal
        $roles_internal = [
            'superadmin',
            'frontoffice',
            'backoffice',
            'stafpimpinan',
            'sekretarisumum',
            'stafbinpres',
            'binpres',
            'sekretarisdua',
            'ketuadua',
            'ketuaumum',
            'keuangan',
            'bai',
        ];
        if (in_array(strtolower($user->role), $roles_internal)) {
            // Peran internal melihat semua proposal, tetapi istilah pencarian tetap berlaku
            $proposals = $query->latest()->get(); // Gunakan paginasi juga untuk peran internal agar konsisten
            return view('pages.data-proposal-internal', compact('proposals'));
        } else {
            // Untuk peran 'klien', filter berdasarkan user_id
            $proposals = $query->where('user_id', $user->id)->latest()->get(); // Juga paginasi untuk klien
            return view('pages.data-proposal', compact('proposals'));
        }
    }


    public function create()

    {
        // Ambil data cabang olahraga dari API
        $response = Http::withOptions([
            'verify' => false,  // Menonaktifkan verifikasi SSL sementara 
            'timeout' => 30,
        ])->get('https://koni-kotabandung.or.id/api/cabor');


        if ($response->successful()) {
            $caborData = $response->json();
        } else {
            $caborData = [];
            Log::error('Gagal mengambil data dari API Cabor');
        }


        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Menemukan nama cabang olahraga berdasarkan cabor_id
        $currentCaborName = null;
        if ($user->cabor_id) {
            // Jika pengguna sudah memiliki cabor_id, cari nama cabang olahraga
            foreach ($caborData as $cabor) {
                if ($cabor['id_cabor'] == $user->cabor_id) {
                    $currentCaborName = $cabor['nama_cabor'];  // Sesuaikan dengan atribut API
                    break;
                }
            }
        }

        // Kirim data cabang olahraga dan data pengguna ke view
        return view('Pages.ajukan-proposal', compact('user', 'caborData', 'currentCaborName'));
    }

    //   Menyimpan data proposal
    public function store(Request $request)
    {
        // Validasi form
        $validatedData = $request->validate([
            'judul_berkas' => 'required|string|max:255',
            'pengaju' => 'required|string|max:255',
            'no_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_berkas' => 'required|array', // Pastikan jenis_berkas adalah array
            'jenis_berkas.*' => 'in:surat,proposal,barang', // Validasi setiap item dalam array jenis_berkas
            'ringkasan_berkas' => 'required|string',
            'tujuan_berkas' => 'required|string',
            'cabang_olahraga' => 'required|string', // Menyimpan ID cabang olahraga atau mitra
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
            'tgl_pengajuan' => 'required|date',
            'file_utama' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'nama_petugas' => 'required|string|max:255',
            'no_telepon_petugas' => 'required|string|max:20',
        ]);

        // Menggabungkan array jenis_berkas menjadi string yang dipisahkan koma
        $jenisBerkas = implode(',', $request->jenis_berkas);

        // Menyimpan file jika ada
        $filePath = null;
        if ($request->hasFile('file_utama')) {
            $filePath = $request->file('file_utama')->store('proposals');
        }

        // Menyimpan data proposal ke dalam database
        $proposal = Proposal::create([
            'user_id' => Auth::id(),
            'judul_berkas' => $validatedData['judul_berkas'],
            'pengaju' => $validatedData['pengaju'],
            'no_surat' => $validatedData['no_surat'],
            'perihal' => $validatedData['perihal'],
            'ringkasan_berkas' => $validatedData['ringkasan_berkas'],
            'tujuan_berkas' => $validatedData['tujuan_berkas'],
            'cabang_olahraga' => $validatedData['cabang_olahraga'],
            'no_telepon' => $validatedData['no_telepon'],
            'email' => $validatedData['email'],
            'alamat' => $validatedData['alamat'],
            'tgl_pengajuan' => $validatedData['tgl_pengajuan'],
            'file_utama' => $filePath,
            'nama_petugas' => $validatedData['nama_petugas'],
            'no_telepon_petugas' => $validatedData['no_telepon_petugas'],
            'jenis_berkas' => $jenisBerkas,  // Menyimpan jenis_berkas sebagai string
            // 'user_id' => auth()->id(),
            'status' => 'diterima',
        ]);

        // Tracking otomatis
        ProposalTrack::create([
            'proposal_id' => $proposal->id,
            'status_label' => 'Proposal telah diterima oleh Front Office',
            'actor' => 'Front Office',
        ]);

        // Redirect atau memberikan respons setelah berhasil
        return redirect()->route('klien.proposal.index')->with('success', 'Proposal berhasil dikirim.');
    }



    public function show(string $id)
    {
        $user = Auth::user();

        // Role internal yang boleh melihat semua proposal
        $roles_internal = [
            'superadmin',
            'frontoffice',
            'backoffice',
            'stafpimpinan',
            'sekretarisumum',
            'stafbinpres',
            'binpres',
            'sekretarisdua',
            'ketuadua',
            'ketuaumum',
            'keuangan',
            'bai',
        ];

        if (in_array(strtolower($user->role), $roles_internal)) {
            // Bisa lihat semua proposal
            $proposal = Proposal::with(['tracks' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])->findOrFail($id);

            return view('Pages.detail-proposal-allRole', compact('proposal'));
        }

        if ($user->role === 'klien') {
            // Klien hanya bisa lihat proposal miliknya
            $proposal = Proposal::where('id', $id)
                ->where('user_id', $user->id)
                ->with(['tracks' => function ($query) {
                    $query->orderBy('created_at', 'asc');
                }])
                ->firstOrFail();

            return view('Pages.detail-proposal', compact('proposal'));
        }

        // Jika bukan role yang dikenali
        abort(403, 'Akses ditolak.');
    }



    public function proposalTerbaru()
    {
        // Mengambil proposal dengan status 'menunggu' (proposal yang memerlukan tindakan)
        $proposals = Proposal::where('status', 'menunggu')
            ->orderBy('tgl_pengajuan', 'desc') // Mengurutkan berdasarkan tanggal pengajuan terbaru
            ->get();

        return view('Pages.proposal-terbaru', compact('proposals'));
    }



    public function downloadTrackAttachment($filename)
    {
        // Asumsikan file attachment disimpan di storage/app/track_attachments/
        $filePath = 'track_attachments/' . $filename;

        if (Storage::disk('local')->exists($filePath)) {
            // Log untuk debugging
            \Log::info("Attempting to serve track attachment: " . storage_path('app/' . $filePath));
            return Storage::response($filePath); // Akan ditampilkan di browser
            // Atau untuk memaksa download: return Storage::download($filePath, $filename);
        } else {
            \Log::error("Track attachment NOT found at: " . storage_path('app/' . $filePath));
            abort(404, 'File lampiran tidak ditemukan.');
        }
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'posisiProposal' => 'required|string',
            'statusProposal' => 'required|string',
            'keterangan' => 'nullable|string|max:255',
            'finalize_action' => 'nullable|boolean',
        ]);

        $proposal = Proposal::findOrFail($id);


        $newStatus = $request->input('statusProposal');
        $statusLabel = $this->getStatusLabel($newStatus);
        if ($request->has('finalize_action') && $request->input('finalize_action') == 1) {
            $newStatus = 'disetujui';
            $statusLabel = 'Proposal Selesai (Disetujui)';
            $keterangan = $request->input('keterangan') ?? 'Proposal telah diselesaikan dan disetujui secara final.';
        }

        $proposal->status = $newStatus;

        $proposal->save();

        $track = new ProposalTrack();
        $track->proposal_id = $proposal->id;
        $track->status_label = $statusLabel;
        $track->position = $request->posisiProposal;
        $track->keterangan = $keterangan;
        $track->actor = auth()->user()->name ?? 'System';
        $track->save();
        return redirect()->route('superadmin.proposal.show', $proposal->id)->with('success', 'Status proposal berhasil diubah.');
    }


    private function getStatusLabel(string $status): string
    {
        switch ($status) {
            case 'diterima':
                return 'Proposal Diterima';
            case 'diproses':
                return 'Sedang Diproses';
            case 'disetujui':
                return 'Disetujui';
            case 'ditolak':
                return 'Ditolak';
            case 'revisi':
                return 'Butuh Revisi';
            case 'selesai':
                return 'Selesai';
            default:
                return ucfirst($status);
        }
    }

    public function tandaTerima($id)
    {
        $proposal = Proposal::findOrFail($id); // Ambil data proposal berdasarkan ID
        return view('Pages.tanda-terima', compact('proposal'));
    }

    public function trackingPublic($id)
    {
        $proposal = Proposal::with('tracks')->findOrFail($id);
        return view('Pages.tracking-public', compact('proposal'));
    }


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
            'Pengaju',
            'Cabor/Mitra',
            'Tanggal Pengajuan',
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
                    $proposal->nama_cabor,
                    Carbon::parse($proposal->tgl_pengajuan)->format('d M Y'),
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
