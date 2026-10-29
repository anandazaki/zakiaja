@extends('layouts.sekolah')

@section('content')
<article class="max-w-3xl mx-auto px-4 py-20">
    <a href="{{ url('/') }}" class="text-sm text-brand font-semibold">&larr; Kembali ke Beranda</a>
    <p class="mt-6 text-xs font-extrabold tracking-[0.2em] uppercase text-leaf">{{ $sub }}</p>
    <h1 class="text-4xl font-extrabold text-navy mt-1">{{ $judul }}</h1>
    @if (!empty($gambar))
        <img src="{{ asset('storage/' . $gambar) }}" alt="{{ $judul }}" class="mt-6 w-full max-h-96 object-cover rounded-2xl">
    @endif
    <p class="mt-6 leading-relaxed text-slate-600">{{ $isi }}</p>
</article>
@endsection