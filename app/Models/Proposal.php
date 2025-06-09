<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProposalTrack;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul_berkas',
        'pengaju',
        'jenis_berkas',
        'no_surat',
        'perihal',
        'ringkasan_berkas',
        'tujuan_berkas',
        'cabang_olahraga',
        'no_telepon',
        'email',
        'alamat',
        'tgl_pengajuan',
        'status',
        'file_utama',
        'nama_petugas',
        'no_telepon_petugas',
        'is_finished',
    ];

    public function tracks()
    {
        return $this->hasMany(ProposalTrack::class)->orderBy('created_at', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'cabang_olahraga', 'id_mitra');
    }
    public function getNamaCaborAttribute()
    {
        $cabors = Cache::remember('list_cabor', 3600, function () {
            $res = Http::withOptions(['verify' => false])
                ->get('https://koni-kotabandung.or.id/api/cabor');
            return $res->successful() ? collect($res->json()) : collect();
        });

        return optional(
            $cabors->firstWhere('id_cabor', (int) $this->cabang_olahraga)
        )['nama_cabor'] ?? 'Nama Cabang Tidak Ditemukan';
    }
}
