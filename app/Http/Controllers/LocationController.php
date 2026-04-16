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

    public function show($param)
    {
        $location = Location::findOrfail($param)->load('user')->loadCount('item'); //mengambil data lokasi beserta relasi user dan menghitung jumlah item
        $petugas = User::where('is_admin', false)->get(); //mengambil data petugas (bukan admin) untuk dropdown pilihan petugas saat menambah lokasi
        return view('location.detail', compact('location', 'petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'petugas' => 'required|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            'name' => $request->nama_lokasi,
            'user_id' => $request->petugas,
            'description' => $request->description,
        ]);

        return redirect()->route('location.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')
            ->with('success', 'Lokasi berhasil dipindahkan ke sampah.');
    }

    public function trash()
    {
        $locations = Location::onlyTrashed()->with('user')->withCount('item')->get(); //mengambil data lokasi yang sudah dihapus (soft delete) beserta relasi user dan menghitung jumlah item
        return view('location.trash', compact('locations'));
    }

    public function restore($id)
    {
        $location = Location::withTrashed()->findOrFail($id);
        $location->restore();

        return redirect()->route('location.trash')
            ->with('success', 'Lokasi berhasil dikembalikan.');
    }

    public function forceDelete($id)
    {
        $location = Location::withTrashed()->findOrFail($id);
        $location->forceDelete();

        return redirect()->route('location.trash')
            ->with('success', 'Lokasi berhasil dihapus permanen.');
    }
}


/**
 * CRUD Items
 * copy paste code CRUD lokasi, lalu sesuaikan dengan kebutuhan item
 * Sesuaikan juga relasi antara item dengan lokasi, bisa dilihat di github
 * Gambar tambahkan php artisan storage:link
 * 
 */
