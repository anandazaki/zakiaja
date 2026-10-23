<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Admin SMK Hanjuang</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            navy: '#16405f', brand: '#0b78d1', leaf: '#0f8a5f', soft: '#f5faff'
        } } } };
    </script>
</head>
<body class="bg-soft text-slate-700 antialiased">
@php
    $aktif = request()->route('resource');
    $menuAdmin = [
        ['admin.dashboard', [], '📊', 'Dashboard', request()->routeIs('admin.dashboard')],
        ['admin.profil', [], '🏫', 'Profil Sekolah', request()->routeIs('admin.profil')],
        ['admin.data.index', ['jurusan'], '🎓', 'Jurusan', $aktif === 'jurusan'],
        ['admin.data.index', ['fasilitas'], '🏢', 'Sarana dan Prasarana', $aktif === 'fasilitas'],
        ['admin.data.index', ['prestasi'], '🏆', 'Prestasi', $aktif === 'prestasi'],
        ['admin.data.index', ['kegiatan'], '📅', 'Kegiatan', $aktif === 'kegiatan'],
        ['admin.data.index', ['galeri'], '🖼️', 'Galeri', $aktif === 'galeri'],
        ['admin.data.index', ['guru'], '👩‍🏫', 'Data Guru', $aktif === 'guru'],
    ];
@endphp

<div class="lg:flex min-h-screen">
    <div class="lg:hidden sticky top-0 z-40 bg-navy text-white flex items-center justify-between px-4 h-14">
        <span class="font-extrabold">Admin SMK Hanjuang</span>
        <button type="button" aria-label="Menu" onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <aside id="sidebar" class="hidden lg:flex lg:flex-col lg:w-64 lg:shrink-0 lg:sticky lg:top-0 lg:h-screen bg-navy text-white">
        <div class="hidden lg:flex items-center gap-3 px-5 h-[72px] border-b border-white/10">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="w-10 h-10 object-contain bg-white rounded-lg p-0.5"
                 onerror="this.outerHTML='<span class=&quot;w-10 h-10 rounded-lg bg-brand grid place-items-center font-extrabold&quot;>SH</span>'">
            <div class="leading-tight">
                <p class="font-extrabold">SMK Hanjuang</p>
                <p class="text-xs text-blue-200">Panel Administrator</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-sm font-semibold">
            @foreach ($menuAdmin as [$rute, $param, $ikon, $label, $sedangAktif])
                <a href="{{ route($rute, $param) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ $sedangAktif ? 'bg-white text-navy' : 'text-blue-100 hover:bg-white/10' }}">
                    <span class="w-6 text-center">{{ $ikon }}</span>{{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="p-3 border-t border-white/10 space-y-1 text-sm font-semibold">
            <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-100 hover:bg-white/10">
                <span class="w-6 text-center">🌐</span>Lihat website
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left text-red-200 hover:bg-red-500/20">
                    <span class="w-6 text-center">🚪</span>Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-w-0 p-4 sm:p-8">
        <div class="max-w-5xl mx-auto">
            @if (session('sukses'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg px-4 py-3" role="status">{{ session('sukses') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>