<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = ['nama', 'email', 'password', 'role', 'no_hp', 'institusi'];

    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke tabel Event (sebagai penyelenggara)
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id', 'user_id');
    }

    // Relasi ke tabel Partisipan
   public function partisipans(): HasMany
{
    return $this->hasMany(Partisipan::class, 'user_id', 'user_id');
}

    // Relasi ke tabel Notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id', 'user_id');
    }

    public function laporans(): HasMany
{
    return $this->hasMany(Laporan::class, 'pelapor_id', 'user_id');
}
}
