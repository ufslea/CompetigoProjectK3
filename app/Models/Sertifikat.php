<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $primaryKey = 'sertifikat_id';
    protected $fillable = ['partisipan_id', 'sublomba_id', 'gambar'];

    // Relasi ke Partisipan
    public function partisipan()
    {
        return $this->belongsTo(Partisipan::class, 'partisipan_id', 'partisipan_id');
    }

    // Relasi ke Sub Lomba
    public function sublomba()
    {
        return $this->belongsTo(SubLomba::class, 'sublomba_id', 'sublomba_id');
    }
}
