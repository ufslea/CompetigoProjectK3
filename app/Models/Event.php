<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'events_id';
    protected $fillable = [
        'organizer_id',
        'nama',
        'deskripsi',
        'url',
        'tanggal_mulai',
        'tanggal_akhir',
        'status'
    ];

    // Relasi ke user (penyelenggara)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id', 'user_id');
    }

    // Relasi ke Sub Lomba
    public function subLombas()
    {
        return $this->hasMany(SubLomba::class, 'event_id', 'events_id');
    }

    // Relasi ke Pengumuman
    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class, 'events_id', 'events_id');
    }
}
