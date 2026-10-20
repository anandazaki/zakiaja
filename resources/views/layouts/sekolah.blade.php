<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil->nama }} | Website Profil Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            navy: '#16405f', brand: '#0b78d1', leaf: '#0f8a5f', soft: '#f5faff'
        } } } };
    </script>
    <style>html { scroll-padding-top: 90px; }</style>
</head>
<body class="bg-white text-slate-700 antialiased">

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 h-[72px] flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
           <img src="{{ asset('img/smkhanjuang.jpg') }}" alt="Logo" class="w-11 h-11 object-contain">
            <span class="leading-tight">
                <span class="block font-extrabold text-navy tracking-wide">{{ strtoupper($profil->nama) }}</span>
                <span class="block text-[10px] font-semibold text-brand uppercase">{{ $profil->tagline }}</span>
            </span>
        </a>
        <nav class="hidden md:flex gap-6 text-sm font-semibold text-navy">
            @foreach (['beranda' => 'Beranda', 'jurusan' => 'Jurusan', 'profil' => 'Profil', 'fasilitas' => 'Sarana dan Prasarana', 'prestasi' => 'Prestasi', 'kegiatan' => 'Kegiatan', 'galeri' => 'Galeri', 'kontak' => 'Kontak'] as $id => $label)
                <a href="{{ url('/') }}#{{ $id }}" class="hover:text-brand">{{ $label }}</a>
            @endforeach
        </nav>
    </div>
</header>

<main>@yield('content')</main>

<footer class="bg-[#0f2f47] text-slate-300 text-center text-sm py-6">
    &copy; {{ date('Y') }} {{ $profil->nama }}. Hak cipta dilindungi.
</footer>
</body>
</html>