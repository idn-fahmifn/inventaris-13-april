<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// grup khusus area admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role'])->group(function () {

    // dashboar admin
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Petugas
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');

    // lokasi
    Route::get('/location', [LocationController::class,'index'])->name('location.index');
    Route::post('/location', [LocationController::class,'store'])->name('location.store');
    Route::get('/location/{location}', [LocationController::class,'show'])->name('location.show');
    Route::put('/location/{location}', [LocationController::class,'update'])->name('location.update');
    Route::delete('/location/{location}', [LocationController::class,'destroy'])->name('location.destroy');

});

// grup khusus area petugas
Route::prefix('petugas')->middleware(['auth', 'verified'])->group(function () {

    // dashboar admin
    Route::get('/dashboard', [DashboardController::class, 'petugas'])->name('dashboard.petugas');
    
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
