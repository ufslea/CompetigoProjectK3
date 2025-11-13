<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubLomba extends Model
{
    protected $primaryKey = 'sublomba_id';
    protected $table = 'sub_lomba';
    protected $fillable = [
        'event_id',
        'nama',
        'kategori',
        'deskripsi',
        'link',
        'deadline',
        'gambar',
        'status'
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'events_id');
    }

    // Relasi ke Partisipan
    public function partisipan()
    {
        return $this->hasMany(Partisipan::class, 'sublomba_id', 'sublomba_id');
    }

    // Relasi ke Hasil
    public function hasil()
    {
        return $this->hasMany(Hasil::class, 'sublomba_id', 'sublomba_id');
    }

    // Relasi ke Sertifikat
    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'sublomba_id', 'sublomba_id');
    }
}
