@extends('layouts.admin')
@section('title', $title)

@section('content')
<a href="{{ $back }}" class="text-sm font-semibold text-brand hover:underline">&larr; Kembali</a>
<h1 class="mt-3 text-2xl font-extrabold text-navy">{{ ucfirst($title) }}</h1>

<form method="POST" action="{{ $action }}" class="mt-6 bg-white rounded-xl border border-slate-200 p-6 space-y-5">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    @foreach ($fields as $name => $f)
        @php
            [$label, $tipe] = $f;
            $nilai = $item->exists ? $item->{$name} : ($f[3] ?? '');
            if ($nilai instanceof \DateTimeInterface) { $nilai = $nilai->format('Y-m-d'); }
            $nilai = old($name, $nilai);
            $kelas = 'w-full rounded-lg border px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand '
                   . ($errors->has($name) ? 'border-red-400' : 'border-slate-200');
        @endphp
        <div>
            <label for="{{ $name }}" class="block text-sm font-semibold text-navy mb-1.5">{{ $label }}</label>
            @if ($tipe === 'textarea')
                <textarea id="{{ $name }}" name="{{ $name }}" rows="5" class="{{ $kelas }}">{{ $nilai }}</textarea>
            @else
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $tipe }}" value="{{ $nilai }}" class="{{ $kelas }}">
            @endif
            @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    @endforeach

    <div class="flex gap-3 pt-2">
        <button type="submit" class="bg-brand hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-lg transition">Simpan perubahan</button>
        <a href="{{ $back }}" class="px-6 py-2.5 rounded-lg border border-slate-200 font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
    </div>
</form>
@endsection