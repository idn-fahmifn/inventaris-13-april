<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = []; //massasigment agar semua column bisa dibaca

    protected $casts = [
        'created_at' => 'datetime', // memastikan tipe data datetime
        'updated_at' => 'datetime',
    ];

    // relasi ke user (petugas)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relasi ke item (banyak item dalam 1 lokasi)
    public function item()
    {
        return $this->hasMany(Item::class, 'item_id');
    }

}
