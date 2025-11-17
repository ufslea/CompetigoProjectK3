<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'events_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'organizer_id',
        'nama',
        'deskripsi',
        'url',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
        'banner_event',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function favorits()
    {
        return $this->hasMany(Favorit::class, 'events_id', 'events_id');
    }
}
