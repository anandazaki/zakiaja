<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Admin SMK Hanjuang</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    {{-- CSS admin dilayani langsung dari public/css/admin.css (tanpa build / Vite / CDN). ?v= memaksa browser memuat versi terbaru. --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ @filemtime(public_path('css/admin.css')) ?: 1 }}">
</head>
<body class="admin">
@php
    $aktif = request()->route('resource');
    // [nama route, parameter, ikon, label, apakah sedang aktif]
    $menuAdmin = [
        ['admin.dashboard',  [],            'dashboard', 'Dashboard',            request()->routeIs('admin.dashboard')],
        ['admin.beranda',    [],            'beranda',   'Beranda',              request()->routeIs('admin.beranda*')],
        ['admin.data.index', ['jurusan'],   'jurusan',   'Jurusan',              $aktif === 'jurusan'],
        ['admin.profil',     [],            'profil',    'Profil',               request()->routeIs('admin.profil*')],
        ['admin.data.index', ['fasilitas'], 'fasilitas', 'Sarana dan Prasarana', $aktif === 'fasilitas'],
        ['admin.data.index', ['prestasi'],  'prestasi',  'Prestasi',             $aktif === 'prestasi'],
        ['admin.data.index', ['kegiatan'],  'kegiatan',  'Kegiatan',             $aktif === 'kegiatan'],
        ['admin.data.index', ['galeri'],    'galeri',    'Galeri',               $aktif === 'galeri'],
        ['admin.kontak',     [],            'kontak',    'Kontak',               request()->routeIs('admin.kontak*')],
        ['admin.data.index', ['guru'],      'guru',      'Data Guru',            $aktif === 'guru'],
    ];
    $namaAdmin = auth()->user()->username ?? auth()->user()->name ?? 'admin';
@endphp

<div class="adm-shell">

    {{-- Latar gelap saat menu HP/tablet terbuka --}}
    <div id="tirai" class="adm-tirai"></div>

    {{-- ================= Sidebar ================= --}}
    <aside id="sidebar" class="adm-sidebar" aria-label="Navigasi admin">
        <div class="adm-brand">
            <span class="adm-logo">
                <img src="{{ asset('img/logo.jpg') }}" alt="" width="36" height="36"
                     onerror="this.parentNode.classList.add('tanpa-gambar')">
                <span class="adm-logo-teks">SH</span>
            </span>
            <span class="adm-brand-nama">SMK HANJUANG</span>
        </div>

        <nav class="adm-nav" aria-label="Menu admin">
            @foreach ($menuAdmin as [$rute, $param, $ikon, $label, $sedangAktif])
                <a href="{{ route($rute, $param) }}" class="adm-link {{ $sedangAktif ? 'is-aktif' : '' }}" @if ($sedangAktif) aria-current="page" @endif>
                    @include('admin.partials.ikon', ['ikonNama' => $ikon, 'ikonUkuran' => 20])
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <div class="adm-foot">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="adm-link">
                @include('admin.partials.ikon', ['ikonNama' => 'globe', 'ikonUkuran' => 20])
                <span>Lihat Website</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="adm-link">
                    @include('admin.partials.ikon', ['ikonNama' => 'logout', 'ikonUkuran' => 20])
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ================= Area utama ================= --}}
    <div class="adm-main">

        {{-- Navbar atas: tombol menu (HP/tablet) di kiri, akun admin di kanan --}}
        <header class="adm-top">
            <button type="button" id="buka-menu" class="adm-menu-btn" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
                @include('admin.partials.ikon', ['ikonNama' => 'menu', 'ikonUkuran' => 24])
            </button>
            <span class="adm-top-brand">SMK HANJUANG</span>

            <span class="adm-akun" title="Login sebagai {{ $namaAdmin }}">
                <span class="adm-avatar">@include('admin.partials.ikon', ['ikonNama' => 'user', 'ikonUkuran' => 18])</span>
                <span class="adm-akun-nama">{{ $namaAdmin }}</span>
            </span>
        </header>

        <main class="adm-content">
            <div class="adm-wrap">
                @if (session('sukses'))
                    <div data-notif class="notif notif-ok" role="status">
                        @include('admin.partials.ikon', ['ikonNama' => 'cek', 'ikonUkuran' => 18])
                        <span>{{ session('sukses') }}</span>
                    </div>
                @endif
                @if (session('galat') || $errors->any())
                    <div class="notif notif-err" role="alert">
                        @include('admin.partials.ikon', ['ikonNama' => 'peringatan', 'ikonUkuran' => 18])
                        <span>{{ session('galat') ?? 'Perubahan belum tersimpan. Periksa kembali isian yang ditandai merah.' }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="adm-copy">&copy; {{ date('Y') }} SMK Hanjuang &middot; Admin Panel</footer>
    </div>
</div>

{{-- Dialog konfirmasi hapus --}}
<div id="dialog-hapus" class="modal" role="dialog" aria-modal="true" aria-labelledby="judul-hapus">
    <div class="modal-kotak">
        <h2 id="judul-hapus">Hapus data?</h2>
        <p>Data <strong id="nama-hapus"></strong> akan dihapus permanen beserta file gambarnya. Tindakan ini tidak bisa dibatalkan.</p>
        <div class="modal-aksi">
            <button type="button" id="batal-hapus" class="btn btn-garis">Batal</button>
            <button type="button" id="ya-hapus" class="btn btn-merah">Ya, hapus</button>
        </div>
    </div>
</div>

<script>
    // ---- Menu HP / tablet ----
    const sidebar = document.getElementById('sidebar');
    const tirai = document.getElementById('tirai');
    const tombolMenu = document.getElementById('buka-menu');

    const bukaTutup = (buka) => {
        sidebar.classList.toggle('is-buka', buka);
        tirai.classList.toggle('is-buka', buka);
        document.body.classList.toggle('menu-buka', buka);
        tombolMenu.setAttribute('aria-expanded', buka ? 'true' : 'false');
    };
    tombolMenu.addEventListener('click', () => bukaTutup(!sidebar.classList.contains('is-buka')));
    tirai.addEventListener('click', () => bukaTutup(false));
    sidebar.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => bukaTutup(false)));
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => { if (e.matches) bukaTutup(false); });

    // ---- Konfirmasi sebelum menghapus ----
    const dialog = document.getElementById('dialog-hapus');
    let formHapus = null;
    document.addEventListener('submit', (e) => {
        if (!e.target.matches('form[data-hapus]')) return;
        e.preventDefault();
        formHapus = e.target;
        document.getElementById('nama-hapus').textContent = '"' + (formHapus.dataset.hapus || 'ini') + '"';
        dialog.classList.add('is-buka');
        document.getElementById('batal-hapus').focus();
    });
    const tutupDialog = () => { dialog.classList.remove('is-buka'); formHapus = null; };
    document.getElementById('batal-hapus').addEventListener('click', tutupDialog);
    document.getElementById('ya-hapus').addEventListener('click', () => { if (formHapus) formHapus.submit(); });
    dialog.addEventListener('click', (e) => { if (e.target === dialog) tutupDialog(); });
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Escape') return;
        tutupDialog();
        bukaTutup(false);
    });

    // ---- Notifikasi sukses hilang otomatis ----
    document.querySelectorAll('[data-notif]').forEach((el) => setTimeout(() => el.remove(), 6000));
</script>
</body>
</html>