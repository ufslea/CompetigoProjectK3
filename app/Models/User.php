<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'nomor_identitas',
        'institusi',
        'no_telepon',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Favorit
    public function favorits()
    {
        return $this->hasMany(Favorit::class, 'user_id', 'user_id');
    }

    // Relasi ke Partisipan
    public function partisipans()
    {
        return $this->hasMany(Partisipan::class, 'user_id', 'user_id');
    }

    // Relasi ke Notifikasi
    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'user_id', 'user_id');
    }

    // Relasi ke Event (untuk organizer)
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id', 'user_id');
    }

    // Relasi ke Laporan
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'pelapor_id', 'user_id');
    }
}
