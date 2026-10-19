<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-2 mb-10">
    <div>
        <p class="text-xs font-extrabold tracking-[0.2em] uppercase {{ $terang ?? false ? 'text-emerald-300' : 'text-leaf' }}">{{ $eyebrow }}</p>
        <h2 class="text-4xl font-extrabold {{ $terang ?? false ? 'text-white' : 'text-navy' }}">{{ $judul }}</h2>
    </div>
    @isset($desc)
        <p class="text-slate-500 text-sm md:text-right">{{ $desc }}</p>
    @endisset
</div>