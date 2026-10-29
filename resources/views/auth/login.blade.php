<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | {{ $profil->nama ?? 'SMK Hanjuang' }}</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/jpeg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            navy: '#16405f', brand: '#0b78d1', leaf: '#0f8a5f', soft: '#f5faff', sidebar: '#0a4a9a'
        } } } };
    </script>
</head>
<body class="min-h-screen bg-soft antialiased text-slate-700">

<div class="min-h-screen lg:grid lg:grid-cols-2">
    {{-- Panel gambar (laptop) --}}
    <div class="hidden lg:block relative bg-sidebar">
        <img src="{{ asset('img/smkhanjuang.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-b from-sidebar/80 via-sidebar/30 to-sidebar/70"></div>
        <div class="relative p-10 flex items-center gap-3 text-white">
            <span class="w-12 h-12 rounded-xl bg-brand grid place-items-center font-extrabold">SH</span>
            <span class="leading-tight">
                <span class="block text-xl font-extrabold tracking-wide">SMK HANJUANG</span>
                <span class="block text-[11px] uppercase tracking-wider text-blue-100">{{ $profil->tagline ?? 'Sekolah Unggul & Berkarakter' }}</span>
            </span>
        </div>
    </div>

    {{-- Formulir login --}}
    <div class="flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <span class="w-11 h-11 rounded-xl bg-brand text-white grid place-items-center font-extrabold">SH</span>
                <span class="font-extrabold text-navy tracking-wide">SMK HANJUANG</span>
            </div>

            <h1 class="text-3xl font-extrabold text-navy">Login Admin</h1>
            <p class="mt-2 text-sm text-slate-500">Masuk untuk mengelola konten website SMK Hanjuang.</p>

            @if (session('info'))
                <div class="mt-6 bg-sky-50 border border-sky-200 text-sky-800 text-sm rounded-lg px-4 py-3" role="status">{{ session('info') }}</div>
            @endif

            @if ($errors->any())
                <div class="mt-6 flex gap-2 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3" role="alert">
                    <svg class="w-5 h-5 shrink-0 mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v5m0 3h.01"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.proses') }}" class="mt-6 space-y-5" novalidate>
                @csrf

                <div>
                    <label for="username" class="block text-sm font-semibold text-navy mb-1.5">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                        </span>
                        <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Username"
                               class="w-full rounded-lg border bg-white {{ $errors->has('username') ? 'border-red-400' : 'border-slate-200' }} pl-11 pr-4 py-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-navy mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="10" width="16" height="11" rx="2"/><path stroke-linecap="round" d="M8 10V7a4 4 0 118 0v3"/></svg>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Password"
                               class="w-full rounded-lg border bg-white border-slate-200 pl-11 pr-12 py-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand">
                        <button type="button" id="toggle-password" aria-label="Tampilkan password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-brand">
                            <svg id="ikon-mata" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="ikon-mata-coret" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 5.1A9.6 9.6 0 0112 5c6 0 10 7 10 7a17 17 0 01-3.2 4M6.5 6.6A17 17 0 002 12s4 7 10 7a9.7 9.7 0 004.3-1"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand">Login</button>
            </form>

            <a href="{{ url('/') }}" class="mt-6 inline-block text-sm font-semibold text-brand hover:underline">&larr; Kembali ke website</a>
            <p class="mt-10 text-xs text-slate-400">&copy; {{ date('Y') }} SMK Hanjuang</p>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('password');
    const tombol = document.getElementById('toggle-password');
    tombol.addEventListener('click', () => {
        const tampil = input.type === 'password';
        input.type = tampil ? 'text' : 'password';
        document.getElementById('ikon-mata').classList.toggle('hidden', tampil);
        document.getElementById('ikon-mata-coret').classList.toggle('hidden', !tampil);
        tombol.setAttribute('aria-label', tampil ? 'Sembunyikan password' : 'Tampilkan password');
    });
</script>
</body>
</html>