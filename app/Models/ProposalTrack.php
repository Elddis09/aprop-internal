<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'status_label',
        'actor',
        // 'file_attachment',
    ];

    // Relasi ke Proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }


}
