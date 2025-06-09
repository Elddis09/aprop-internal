<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Proposal;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'no_telepon',
        'jabatan',
        'alamat',
        'kota',
        'cabor_id',
        'cabor_type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'user_id');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
