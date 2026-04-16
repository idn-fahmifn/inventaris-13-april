<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        $locations = Location::all();
        return view('item.index', [
            'items' => $items,
            'locations' => $locations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // harus disesuaikan dengan name yang ada di form.
            'nama_barang' => 'required|string|min:3|max:20',
            'lokasi' => 'required|integer|exists:locations,id',
            'jumlah' => 'required|integer|min:0|max:1000',
            'kondisi' => 'required|in:new,good,broke,maintenance',
            'gambar' => 'required|file|max:2048|mimes:png,jpg,jpeg,gif,svg,webp',
            'deskripsi' => 'required',
        ]);

        // buat array untuk data yang ingin disimpan
        $data_simpan = [
            'name' => $request->input('nama_barang'),
            'location_id' => $request->input('lokasi'),
            'quantity' => $request->input('jumlah'),
            'condition' => $request->input('kondisi'),
            'desc' => $request->input('deskripsi'),
        ];

        // jika ada gambar yang diupload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $lokasi = 'public/images/items';
            $format = $gambar->extension();
            $nama = 'siinventaris_' . Carbon::now('Asia/Jakarta')
                ->format('YmdHis') . random_int(000, 999) . '.' . $format;
            $data_simpan['image'] = $nama;

            // simpan gambar ke lokasi yang sudah di define
            $gambar->storeAs($lokasi, $nama);
        }


        // simpan data array data_simpan ke database
        Item::create($data_simpan);
        return redirect()->route('item.index')->with('success', 'Barang berhasil disimpan');
    }

    public function show($param)
    {
        // find digunakan untuk mencari ID
        $item = Item::findOrFail($param);
        $locations = Location::all();
        return view('item.detail', compact('item', 'locations'));
    }

    public function update(Request $request, $param)
    {
        // cari data mana yang mau diedit
        $data = Item::findOrFail($param);

        $request->validate([
            // harus disesuaikan dengan name yang ada di form.
            'nama_barang' => 'required|string|min:3|max:20',
            'lokasi' => 'required|integer|exists:locations,id',
            'jumlah' => 'required|integer|min:0|max:1000',
            'kondisi' => 'required|in:new,good,broke,maintenance',
            'gambar' => 'nullable|file|max:2048|mimes:png,jpg,jpeg,gif,svg,webp',
            'deskripsi' => 'required',
        ]);

        // buat array untuk data yang ingin disimpan
        $data_simpan = [
            'name' => $request->input('nama_barang'),
            'location_id' => $request->input('lokasi'),
            'quantity' => $request->input('jumlah'),
            'condition' => $request->input('kondisi'),
            'desc' => $request->input('deskripsi'),
        ];

        // jika ada gambar yang diupload
        if ($request->hasFile('gambar')) {

            // menghapus path lama

            $path_lama = 'public/images/items/' . $data->image;

            if ($data->image && Storage::exists($path_lama)) {
                Storage::delete($path_lama);
            }

            $gambar = $request->file('gambar');
            $lokasi = 'public/images/items';
            $format = $gambar->extension();
            $nama = 'siinventaris_' . Carbon::now('Asia/Jakarta')
                ->format('YmdHis') . random_int(000, 999) . '.' . $format;
            $data_simpan['image'] = $nama;

            // simpan gambar ke lokasi yang sudah di define
            $gambar->storeAs($lokasi, $nama);
        }

        // simpan data array data_simpan ke database
        $data->update($data_simpan);
        return redirect()->route('item.show', $data->uuid)->with('success', 'Barang berhasil diubah');
    }

    public function destroy($param)
    {
        $item = Item::findOrFail($param);
        $item->delete();
        return redirect()->route('item.index')->with('success', 'Barang berhasil dihapus');
    }
}
