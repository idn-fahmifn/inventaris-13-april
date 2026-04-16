<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('user')->withCount('item')->get(); //mengambil data lokasi beserta relasi user dan menghitung jumlah item
        $petugas = User::where('is_admin', false)->get(); //mengambil data petugas (bukan admin) untuk dropdown pilihan petugas saat menambah lokasi
        return view('location.index', compact('locations', 'petugas'));
    }
}
