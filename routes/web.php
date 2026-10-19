<?php

use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SekolahController::class, 'beranda'])->name('beranda');
Route::get('/jurusan/{jurusan}', [SekolahController::class, 'jurusan'])->name('jurusan.show');
Route::get('/kegiatan/{kegiatan}', [SekolahController::class, 'kegiatan'])->name('kegiatan.show');
Route::post('/kontak', [SekolahController::class, 'kirimPesan'])->name('kontak.kirim');