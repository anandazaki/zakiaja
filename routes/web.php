<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;

// ---------- Website publik ----------
Route::get('/', [SekolahController::class, 'beranda'])->name('beranda');
Route::get('/jurusan/{jurusan}', [SekolahController::class, 'jurusan'])->name('jurusan.show');
Route::get('/kegiatan/{kegiatan}', [SekolahController::class, 'kegiatan'])->name('kegiatan.show');
Route::post('/kontak', [SekolahController::class, 'kirimPesan'])->name('kontak.kirim');

// ---------- Login admin ----------
Route::get('/login', [AuthController::class, 'form'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Dashboard admin (wajib login) ----------
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminController::class, 'profilUpdate'])->name('profil.update');

    Route::prefix('{resource}')
        ->where(['resource' => 'jurusan|fasilitas|prestasi|kegiatan|galeri|guru', 'id' => '[0-9]+'])
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('data.index');
            Route::get('/tambah', [AdminController::class, 'create'])->name('data.create');
            Route::post('/', [AdminController::class, 'store'])->name('data.store');
            Route::get('/{id}/ubah', [AdminController::class, 'edit'])->name('data.edit');
            Route::put('/{id}', [AdminController::class, 'update'])->name('data.update');
            Route::delete('/{id}', [AdminController::class, 'destroy'])->name('data.destroy');
        });
});