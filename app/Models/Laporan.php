<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';
    public $timestamps = true;

    protected $fillable = [
        'pelapor_id',
        'events_id',
        'judul',
        'deskripsi',
        'status',
        'bukti',
        'tanggapan',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relations
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'events_id');
    }
}