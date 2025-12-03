<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partisipan extends Model
{
    protected $table = 'partisipans';
    protected $primaryKey = 'partisipan_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'sublomba_id',
        'institusi',
        'kontak',
        'file_karya',
        'status',
        'registered_at',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
        'nominal_bayar',
        'handle_sosmed',
        'deskripsi_karya'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function sublomba()
    {
        return $this->belongsTo(SubLomba::class, 'sublomba_id', 'sublomba_id');
    }

    public function hasil()
    {
        return $this->hasOne(Hasil::class, 'partisipan_id', 'partisipan_id');
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'partisipan_id', 'partisipan_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }
}
