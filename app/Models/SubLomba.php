<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubLomba extends Model
{
    protected $primaryKey = 'sublomba_id';
    protected $table = 'sub_lomba';
    public $timestamps = true;
    
    protected $fillable = [
        'event_id',
        'nama',
        'kategori',
        'deskripsi',
        'link',
        'deadline',
        'gambar',
        'status',
        'jenis_sublomba',
        'requires_submission'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'events_id');
    }

    public function partisipans()
    {
        return $this->hasMany(Partisipan::class, 'sublomba_id', 'sublomba_id');
    }

    public function hasil()
    {
        return $this->hasMany(Hasil::class, 'sublomba_id', 'sublomba_id');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'sublomba_id', 'sublomba_id');
    }
}
