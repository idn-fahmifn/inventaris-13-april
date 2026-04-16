<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{

    use SoftDeletes;

    protected $guarded = []; //massasigment agar semua column bisa dibaca

    protected $casts = [
        'created_at' => 'datetime', // memastikan tipe data datetime
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // relasi ke user (petugas)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relasi ke item (banyak item dalam 1 lokasi)
    public function item()
    {
        return $this->hasMany(Item::class, 'location_id');
    }
}
