<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $primaryKey = 'pengumuman_id';
    protected $fillable = ['events_id', 'judul', 'isi'];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'events_id');
    }
}
