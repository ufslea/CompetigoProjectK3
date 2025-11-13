<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $primaryKey = 'hasil_id';
    protected $fillable = ['sublomba_id', 'partisipan_id', 'rank', 'deskripsi'];

    // Relasi ke Sub Lomba
    public function sublomba()
    {
        return $this->belongsTo(SubLomba::class, 'sublomba_id', 'sublomba_id');
    }

    // Relasi ke Partisipan
    public function partisipan()
    {
        return $this->belongsTo(Partisipan::class, 'partisipan_id', 'partisipan_id');
    }
}
