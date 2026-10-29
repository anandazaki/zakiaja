@extends('layouts.admin')
@section('title', $d['title'])

@php
    $thumb = $d['thumb'] ?? null;
    $namaItem = fn ($item) => $item->judul ?? $item->nama ?? 'ini';
@endphp

@section('content')
<div class="page-head">
    <div>
        <h1 class="judul">{{ $d['title'] }}</h1>
        <p class="subjudul">{{ $d['subtitle'] }}</p>
    </div>
    <a href="{{ route('admin.data.create', $resource) }}" class="btn btn-biru">
        @include('admin.partials.ikon', ['ikonNama' => 'plus', 'ikonUkuran' => 16])
        Tambah {{ ucfirst($d['single']) }}
    </a>
</div>

@if ($resource === 'galeri')
    {{-- Galeri: tampilan kisi --}}
    @if ($items->isEmpty())
        <div class="kosong-kartu">Belum ada foto atau video. Klik "Tambah {{ ucfirst($d['single']) }}" untuk mengunggah.</div>
    @else
        <div class="galeri-grid">
            @foreach ($items as $item)
                <div class="galeri-item">
                    <div class="galeri-media">
                        @if ($item->file && $item->tipe === 'video')
                            <video src="{{ asset('storage/' . $item->file) }}" preload="metadata" muted></video>
                        @elseif ($item->file)
                            <img src="{{ asset('storage/' . $item->file) }}" alt="{{ $item->judul }}" loading="lazy">
                        @else
                            <span>Belum ada file<br>(ubah untuk mengunggah)</span>
                        @endif
                    </div>
                    <div class="galeri-bawah">
                        <p class="galeri-judul" title="{{ $item->judul }}">{{ $item->judul }}</p>
                        <div class="aksi">
                            <a href="{{ route('admin.data.edit', [$resource, $item->id]) }}" aria-label="Edit {{ $item->judul }}" class="btn btn-sm btn-biru">
                                @include('admin.partials.ikon', ['ikonNama' => 'edit', 'ikonUkuran' => 14])
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.data.destroy', [$resource, $item->id]) }}" data-hapus="{{ $item->judul }}">
                                @csrf @method('DELETE')
                                <button type="submit" aria-label="Hapus {{ $item->judul }}" class="btn btn-sm btn-merah">
                                    @include('admin.partials.ikon', ['ikonNama' => 'hapus', 'ikonUkuran' => 14])
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@else
    <div class="kartu tabel-bungkus">
        <table class="tabel">
            <thead>
                <tr>
                    <th class="no">No</th>
                    @foreach ($d['columns'] as $kolom)
                        <th>{{ $d['fields'][$kolom][0] ?? ucfirst($kolom) }}</th>
                    @endforeach
                    @if ($thumb)<th>Gambar</th>@endif
                    <th class="kanan">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="no" data-label="No">{{ $loop->iteration }}</td>
                        @foreach ($d['columns'] as $kolom)
                            @php $v = $item->{$kolom}; @endphp
                            <td data-label="{{ $d['fields'][$kolom][0] ?? ucfirst($kolom) }}">{{ $v instanceof \DateTimeInterface ? $v->translatedFormat('d F Y') : \Illuminate\Support\Str::limit((string) $v, 70) }}</td>
                        @endforeach
                        @if ($thumb)
                            <td data-label="Gambar">
                                @if ($item->{$thumb})
                                    <img src="{{ asset('storage/' . $item->{$thumb}) }}" alt="" class="thumb" loading="lazy">
                                @else
                                    <span class="strip">—</span>
                                @endif
                            </td>
                        @endif
                        <td class="kanan td-aksi">
                            <div class="aksi">
                                <a href="{{ route('admin.data.edit', [$resource, $item->id]) }}" aria-label="Edit {{ $namaItem($item) }}" class="btn btn-sm btn-biru">
                                    @include('admin.partials.ikon', ['ikonNama' => 'edit', 'ikonUkuran' => 14])
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.data.destroy', [$resource, $item->id]) }}" data-hapus="{{ $namaItem($item) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" aria-label="Hapus {{ $namaItem($item) }}" class="btn btn-sm btn-merah">
                                        @include('admin.partials.ikon', ['ikonNama' => 'hapus', 'ikonUkuran' => 14])
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($d['columns']) + ($thumb ? 3 : 2) }}" class="kosong">Belum ada data. Klik "Tambah {{ ucfirst($d['single']) }}" untuk mengisi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif
@endsection