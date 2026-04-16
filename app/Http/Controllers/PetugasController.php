<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->withCount('locations')->get(); //menampilkan semu data petugas (bukan admin)
        return view('petugas.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_petugas' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ]);

        User::create([
            'name' => $request->nama_petugas,
            'email' => $request->email,
            'password' => Hash::make('password'),
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan.');

    }
}
