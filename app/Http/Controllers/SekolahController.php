<?php

namespace App\Http\Controllers;

use App\Models\{Fasilitas, Galeri, Jurusan, Kegiatan, Pesan, Prestasi, Profil};
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function beranda()
    {
        return view('beranda', [
            'profil'    => Profil::firstOrFail(),
            'jurusans'  => Jurusan::all(),
            'fasilitas' => Fasilitas::all(),
            'prestasis' => Prestasi::orderByDesc('tahun')->get(),
            'kegiatans' => Kegiatan::latest('tanggal')->take(6)->get(),
            'galeris'   => Galeri::all(),
        ]);
    }

    public function jurusan(Jurusan $jurusan)
    {
        return view('detail', [
            'profil' => Profil::firstOrFail(),
            'judul'  => $jurusan->nama,
            'sub'    => 'Program Keahlian',
            'isi'    => $jurusan->deskripsi,
        ]);
    }

    public function kegiatan(Kegiatan $kegiatan)
    {
        return view('detail', [
            'profil' => Profil::firstOrFail(),
            'judul'  => $kegiatan->judul,
            'sub'    => $kegiatan->tanggal->translatedFormat('d F Y'),
            'isi'    => $kegiatan->deskripsi,
        ]);
    }

    public function kirimPesan(Request $request)
    {
        Pesan::create($request->validate([
            'nama'  => 'required|max:100',
            'email' => 'required|email|max:150',
            'pesan' => 'required|max:2000',
        ]));

        return redirect(url('/') . '#kontak')->with('sukses', 'Pesan Anda berhasil dikirim. Terima kasih!');
    }
}