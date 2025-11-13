<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partisipan extends Model
{
    protected $primaryKey = 'partisipan_id';
    protected $fillable = [
        'user_id',
        'sublomba_id',
        'institusi',
        'kontak',
        'file_karya',
        'status',
        'registered_at'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Sub Lomba
    public function sublomba()
    {
        return $this->belongsTo(SubLomba::class, 'sublomba_id', 'sublomba_id');
    }

    // Relasi ke Hasil
    public function hasil()
    {
        return $this->hasOne(Hasil::class, 'partisipan_id', 'partisipan_id');
    }

    // Relasi ke Sertifikat
    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'partisipan_id', 'partisipan_id');
    }
}
