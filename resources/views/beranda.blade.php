@extends('layouts.sekolah')

@section('content')

{{-- BERANDA --}}
<section id="beranda" class="bg-gradient-to-br from-navy via-[#14608f] to-brand text-white">
    <div class="max-w-6xl mx-auto px-4 py-28 text-center">
        <p class="text-sm font-bold tracking-[0.25em] uppercase text-emerald-300">Selamat Datang di</p>
        <h1 class="text-5xl md:text-6xl font-extrabold mt-3">{{ $profil->nama }}</h1>
        <p class="mt-4 text-lg text-blue-100">{{ $profil->tagline }}</p>
        <a href="#kontak" class="inline-block mt-8 bg-white text-navy font-bold px-7 py-3 rounded-lg shadow">Hubungi Kami</a>
    </div>
</section>

{{-- MENU CEPAT --}}
<div class="max-w-6xl mx-auto px-4 -mt-10 relative z-10">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-100 grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-100">
        @foreach ([['jurusan','🎓','Jurusan','Program keahlian'],['Sarana dan Prasarana','🏫','Sarana dan Prasarana','Sarana sekolah'],['prestasi','🏆','Prestasi','Pencapaian siswa'],['kegiatan','📅','Kegiatan','Aktivitas sekolah']] as [$id,$ic,$jd,$sb])
            <a href="#{{ $id }}" class="flex items-center gap-4 p-6 hover:bg-soft transition">
                <span class="text-4xl">{{ $ic }}</span>
                <span><span class="block font-bold text-navy">{{ $jd }}</span><span class="block text-sm text-slate-500">{{ $sb }}</span></span>
            </a>
        @endforeach
    </div>
</div>

{{-- JURUSAN --}}
<section id="jurusan" class="max-w-6xl mx-auto px-4 pt-24 pb-16">
    @include('partials.judul', ['eyebrow' => 'Program Keahlian', 'judul' => 'Jurusan', 'desc' => 'Pilihan program keahlian yang dapat dikembangkan sesuai minat dan bakat siswa.'])
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($jurusans as $j)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col">
                <span class="w-14 h-14 rounded-full grid place-items-center text-2xl" style="background: {{ $j->warna }}">{{ $j->icon }}</span>
                <h3 class="text-xl font-bold text-navy mt-5">{{ $j->nama }}</h3>
                <p class="text-sm text-slate-500 mt-3 flex-1">{{ $j->deskripsi }}</p>
                <a href="{{ route('jurusan.show', $j) }}" class="mt-6 self-start bg-brand text-white text-xs font-bold px-4 py-2.5 rounded-lg">Lihat Detail</a>
            </div>
        @endforeach
    </div>
</section>

{{-- PROFIL --}}
<section id="profil" class="bg-soft py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-xs font-extrabold tracking-[0.2em] uppercase text-leaf">Tentang Sekolah</p>
            <h2 class="text-4xl font-extrabold text-navy">Profil Sekolah</h2>
        </div>
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="img">
                <img src="{{ asset('img/smkhanjuang.jpg') }}" alt="Foto Gedung Sekolah" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-navy">{{ $profil->nama }}</h3>
                <p class="mt-3 text-slate-500">{{ $profil->deskripsi }}</p>
                <div class="mt-6 bg-emerald-50 border-l-4 border-leaf rounded-lg p-5">
                    <h4 class="font-bold text-leaf">Visi</h4>
                    <p class="text-sm mt-1">{{ $profil->visi }}</p>
                </div>
                <div class="mt-4 bg-emerald-50 border-l-4 border-leaf rounded-lg p-5">
                    <h4 class="font-bold text-leaf">Misi</h4>
                    <ol class="list-decimal pl-5 text-sm mt-1 space-y-1">
                        @foreach (preg_split('/\r\n|\n/', $profil->misi) as $misi)
                            <li>{{ $misi }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <div class="mt-10 bg-sky-50 border border-sky-100 rounded-2xl p-6">
            <h4 class="font-bold text-navy">Sejarah Singkat</h4>
            <p class="text-sm text-slate-500 mt-1">{{ $profil->sejarah }}</p>
        </div>
    </div>
</section>

{{-- FASILITAS --}}
<section id="fasilitas" class="max-w-6xl mx-auto px-4 py-20">
    @include('partials.judul', ['eyebrow' => 'Sarana Sekolah', 'judul' => 'Sarana dan Prasarana', 'desc' => 'Fasilitas yang mendukung proses belajar mengajar dan kegiatan siswa.'])
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($fasilitas as $f)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="h-44 grid place-items-center text-6xl" style="background: linear-gradient(135deg,{{ $f->warna1 }},{{ $f->warna2 }})">{{ $f->icon }}</div>
                <p class="p-4 text-sm font-bold text-navy">{{ $f->nama }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- PRESTASI --}}
<section id="prestasi" class="bg-soft py-20">
    <div class="max-w-6xl mx-auto px-4">
        @include('partials.judul', ['eyebrow' => 'Pencapaian', 'judul' => 'Prestasi Sekolah', 'desc' => 'Berbagai prestasi yang dapat ditampilkan berdasarkan data sekolah.'])
        <div class="max-w-4xl mx-auto space-y-4">
            @php $medali = ['#fdf0c8', '#e5e7eb', '#fde0c4', '#fbd5e5']; @endphp
            @foreach ($prestasis as $p)
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm flex items-center gap-4 px-5 py-4">
                    <span class="w-11 h-11 rounded-full grid place-items-center text-xl" style="background: {{ $medali[$loop->index % 4] }}">🏅</span>
                    <div class="flex-1">
                        <p class="font-bold text-navy">{{ $p->judul }}</p>
                        <p class="text-xs text-slate-500">Tahun {{ $p->tahun }} · Tingkat {{ $p->tingkat }}</p>
                    </div>
                    <span class="text-brand font-bold">&rsaquo;</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KEGIATAN --}}
<section id="kegiatan" class="max-w-6xl mx-auto px-4 py-20">
    @include('partials.judul', ['eyebrow' => 'Aktivitas Sekolah', 'judul' => 'Kegiatan Sekolah', 'desc' => 'Dokumentasi kegiatan yang berlangsung di ' . $profil->nama . '.'])
    <div class="grid md:grid-cols-3 gap-6">
        @foreach ($kegiatans as $k)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="h-52 grid place-items-center text-7xl" style="background: linear-gradient(135deg,{{ $k->warna1 }},{{ $k->warna2 }})">{{ $k->icon }}</div>
                <div class="p-5">
                    <h3 class="font-bold text-navy text-lg">{{ $k->judul }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ $k->tanggal->translatedFormat('d F Y') }}</p>
                    <a href="{{ route('kegiatan.show', $k) }}" class="inline-block mt-4 bg-brand text-white text-xs font-bold px-4 py-2.5 rounded-lg">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- GALERI --}}
<section id="galeri" class="bg-soft py-20">
    <div class="max-w-6xl mx-auto px-4">
        @include('partials.judul', ['eyebrow' => 'Dokumentasi', 'judul' => 'Galeri', 'desc' => 'Momen kebersamaan warga sekolah.'])
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($galeris as $g)
                <div class="rounded-2xl h-40 grid place-items-center text-5xl relative overflow-hidden" style="background: linear-gradient(135deg,{{ $g->warna1 }},{{ $g->warna2 }})">
                    {{ $g->icon }}
                    <span class="absolute bottom-0 inset-x-0 bg-black/30 text-white text-xs font-semibold text-center py-1.5">{{ $g->judul }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KONTAK --}}
<section id="kontak" class="bg-navy py-20">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-xs font-extrabold tracking-[0.2em] uppercase text-emerald-300">Informasi</p>
            <h2 class="text-4xl font-extrabold text-white">Kontak Sekolah</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-12 text-white">
            <div>
                <h3 class="text-3xl font-extrabold">{{ $profil->nama }}</h3>
                <ul class="mt-6 space-y-4 text-sm">
                    <li>📍 Alamat: {{ $profil->alamat }}</li>
                    <li>📞 Telepon: {{ $profil->telepon }}</li>
                    <li>✉️ Email: {{ $profil->email }}</li>
                    <li>🕐 {{ $profil->jam_kerja }}</li>
                </ul>
            </div>
            <form method="POST" action="{{ route('kontak.kirim') }}" class="space-y-4">
                @csrf
                @if (session('sukses'))
                    <div class="bg-emerald-500 text-white text-sm rounded-lg px-4 py-3">{{ session('sukses') }}</div>
                @endif
                @foreach (['nama' => 'Nama', 'email' => 'Email'] as $name => $label)
                    <div>
                        <input type="{{ $name === 'email' ? 'email' : 'text' }}" name="{{ $name }}" value="{{ old($name) }}" placeholder="{{ $label }}"
                               class="w-full rounded-xl px-4 py-4 text-slate-800 placeholder-slate-400 outline-none">
                        @error($name)<p class="text-red-300 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach
                <div>
                    <textarea name="pesan" rows="5" placeholder="Pesan" class="w-full rounded-xl px-4 py-4 text-slate-800 placeholder-slate-400 outline-none">{{ old('pesan') }}</textarea>
                    @error('pesan')<p class="text-red-300 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button class="bg-brand hover:bg-blue-700 text-white font-bold px-7 py-3.5 rounded-xl">Kirim Pesan</button>
            </form>
        </div>
    </div>
</section>
@endsection