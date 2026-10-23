<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil->nama }} | Website Profil Sekolah</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            navy: '#16405f', brand: '#0b78d1', leaf: '#0f8a5f', soft: '#f5faff'
        } } } };
    </script>
    <style>html { scroll-padding-top: 90px; }</style>
</head>
<body class="bg-white text-slate-700 antialiased">

@php
    $menu = ['beranda' => 'Beranda', 'jurusan' => 'Jurusan', 'profil' => 'Profil', 'fasilitas' => 'Sarana dan Prasarana', 'prestasi' => 'Prestasi', 'kegiatan' => 'Kegiatan', 'galeri' => 'Galeri', 'kontak' => 'Kontak'];
    $ikonGembok = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="11" rx="2"/><path stroke-linecap="round" d="M8 10V7a4 4 0 118 0v3"/></svg>';
@endphp

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 h-[72px] flex items-center justify-between gap-4">
        <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo {{ $profil->nama }}" class="w-11 h-11 object-contain"
                 onerror="this.outerHTML='<span class=&quot;w-11 h-11 rounded-xl bg-brand text-white grid place-items-center font-extrabold&quot;>SH</span>'">
            <span class="leading-tight">
                <span class="block font-extrabold text-navy tracking-wide">{{ strtoupper($profil->nama) }}</span>
                <span class="block text-[10px] font-semibold text-brand uppercase">{{ $profil->tagline }}</span>
            </span>
        </a>

        {{-- Menu desktop --}}
        <nav class="hidden lg:flex items-center gap-5 text-sm font-semibold text-navy">
            @foreach ($menu as $id => $label)
                <a href="{{ url('/') }}#{{ $id }}" class="hover:text-brand whitespace-nowrap">{{ $label }}</a>
            @endforeach
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-brand hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition whitespace-nowrap">
                {!! $ikonGembok !!} Login Admin
            </a>
        </nav>

        {{-- Tombol menu HP --}}
        <button type="button" class="lg:hidden p-2 text-navy" aria-label="Menu"
                onclick="document.getElementById('menu-mobile').classList.toggle('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Menu HP --}}
    <nav id="menu-mobile" class="hidden lg:hidden border-t border-slate-100 bg-white px-4 py-3 text-sm font-semibold text-navy">
        @foreach ($menu as $id => $label)
            <a href="{{ url('/') }}#{{ $id }}" class="block py-2 hover:text-brand"
               onclick="document.getElementById('menu-mobile').classList.add('hidden')">{{ $label }}</a>
        @endforeach
        <a href="{{ route('login') }}" class="mt-2 flex items-center justify-center gap-2 bg-brand hover:bg-blue-700 text-white py-2.5 rounded-lg transition">
            {!! $ikonGembok !!} Login Admin
        </a>
    </nav>
</header>

<main>@yield('content')</main>

<footer class="bg-[#0f2f47] text-slate-300 text-center text-sm py-6">
    &copy; {{ date('Y') }} {{ $profil->nama }}. Hak cipta dilindungi.
</footer>
</body>
</html>