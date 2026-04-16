<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $guarded = []; //massasigment agar semua column bisa dibaca

    protected $casts = [
        'created_at' => 'datetime', // memastikan tipe data datetime
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    // relasi ke location (banyak item dalam 1 lokasi)
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
