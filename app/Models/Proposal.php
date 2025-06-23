<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProposalTrack;
use App\Models\Cabor;

class Proposal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['mitra', 'currentTrack'];

    protected $fillable = [
        'user_id',
        'judul_berkas',
        'pengaju',
        'jenis_berkas',
        'no_surat',
        'perihal',
        'pengcab',
        'agenda_number',
        'tgl_surat',
        'cabang_olahraga',
        'no_telepon',
        'email',
        'alamat',
        'tgl_pengajuan',
        'status',
        'file_utama',
        'nama_petugas',
        'jabatan',
        'is_finished',
        'mitra_id',
        'data_updated_at',          
        'data_updated_by_user_id', 
    ];

    public function tracks()
    {
        return $this->hasMany(ProposalTrack::class)->orderBy('created_at', 'asc');
    }

    public function currentTrack()
    {
        return $this->hasOne(ProposalTrack::class)->where('is_current', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function dataUpdatedByUser()
    {
        return $this->belongsTo(User::class, 'data_updated_by_user_id');
    }

    public function getNamaCaborAttribute($value)
    {
        // 1. Prioritas utama: Jika ada mitra_id DAN relasi mitra sudah dimuat DAN mitra tidak null
        if ($this->mitra_id && $this->relationLoaded('mitra') && $this->mitra) {
            return $this->mitra->nama;
        }

        // 2. Jika tidak ada mitra_id, atau relasi mitra null,
        if (is_numeric($this->attributes['cabang_olahraga'])) {
            $caborId = (int) $this->attributes['cabang_olahraga'];
            $caborLokal = Cabor::where('api_cabor_id', $caborId)->first();

            if ($caborLokal) {
                return $caborLokal->nama_cabor;
            }
            return 'CABOR TIDAK DITEMUKAN (ID: ' . $caborId . ')';
        }

        // 3. Jika 'cabang_olahraga' sudah menyimpan string nama (bukan ID numerik)
        if (!empty($this->attributes['cabang_olahraga'])) {
            return $this->attributes['cabang_olahraga'];
        }

        // 4. Fallback umum jika tidak ada kondisi di atas yang terpenuhi
        return 'Tidak Diketahui';
    }
}
