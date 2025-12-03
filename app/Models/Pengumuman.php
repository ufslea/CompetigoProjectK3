<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $primaryKey = 'pengumuman_id';
    public $timestamps = true;
    
    protected $fillable = ['events_id', 'judul', 'isi'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'events_id');
    }
}
