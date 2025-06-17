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
        'actor_id',
        'from_position',
        'to_position',
        'keterangan',
        'is_current',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    // Relasi ke Proposal
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
    public function actorUser()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
