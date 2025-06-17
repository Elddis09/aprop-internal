<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'tipe'];

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
