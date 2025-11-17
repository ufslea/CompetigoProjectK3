<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $table = 'favorit';
    protected $primaryKey = 'favorit_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'events_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'events_id');
    }
}