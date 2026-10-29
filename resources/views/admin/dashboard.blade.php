@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1 class="judul">Dashboard Admin SMK Hanjuang</h1>
        <p class="subjudul">Selamat datang, {{ auth()->user()->username ?? 'Admin' }}! Berikut ringkasan konten website sekolah.</p>
    </div>
</div>

<div class="grid-kartu">
    @foreach ($kartu as $k)
        <a href="{{ route('admin.data.index', $k['key']) }}" class="stat">
            <span class="kotak-ikon">@include('admin.partials.ikon', ['ikonNama' => $k['ikon'], 'ikonUkuran' => 20])</span>
            <p class="stat-angka">{{ $k['jumlah'] }}</p>
            <p class="stat-label">{{ $k['key'] === 'fasilitas' ? 'Sarana & Prasarana' : $k['label'] }}</p>
        </a>
    @endforeach
</div>

<h2 class="judul-bagian">Menu Cepat</h2>
<div class="grid-kartu grid-kartu-rapat">
    @foreach ([
        ['admin.beranda', [], 'beranda', 'Edit Beranda'],
        ['admin.data.index', ['jurusan'], 'jurusan', 'Kelola Jurusan'],
        ['admin.profil', [], 'profil', 'Kelola Profil'],
        ['admin.data.index', ['fasilitas'], 'fasilitas', 'Kelola Sarana & Prasarana'],
        ['admin.data.index', ['prestasi'], 'prestasi', 'Kelola Prestasi'],
        ['admin.data.index', ['kegiatan'], 'kegiatan', 'Kelola Kegiatan'],
        ['admin.data.index', ['galeri'], 'galeri', 'Kelola Galeri'],
        ['admin.kontak', [], 'kontak', 'Kelola Kontak'],
        ['admin.data.index', ['guru'], 'guru', 'Kelola Data Guru'],
    ] as [$rute, $param, $ikon, $label])
        <a href="{{ route($rute, $param) }}" class="menu-cepat">
            <span class="kotak-ikon">@include('admin.partials.ikon', ['ikonNama' => $ikon, 'ikonUkuran' => 20])</span>
            <span class="teks">{{ $label }}</span>
        </a>
    @endforeach
</div>
@endsection