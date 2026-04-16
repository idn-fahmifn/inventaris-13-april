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

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'petugas' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        Location::create([
            'name' => $request->nama_lokasi,
            'user_id' => $request->petugas,
            'description' => $request->description,
        ]);

        return redirect()->route('location.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }
}
