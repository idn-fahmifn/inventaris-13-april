<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('user')->withCount('item')->get(); //mengambil data lokasi beserta relasi user dan menghitung jumlah item
        return view('location.index', compact('locations'));
    }
}
