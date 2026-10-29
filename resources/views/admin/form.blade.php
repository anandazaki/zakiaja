@extends('layouts.admin')
@section('title', $title)

@section('content')
<div class="form-bungkus {{ ($lebar ?? 'max-w-2xl') === 'max-w-3xl' ? 'form-lebar' : 'form-sempit' }}">
    <a href="{{ $back }}" class="tautan-kembali">&larr; Kembali</a>
    <h1 class="judul judul-form">{{ $title }}</h1>
    @isset($subtitle)<p class="subjudul">{{ $subtitle }}</p>@endisset

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="form-kartu">
        @csrf
        @if ($method !== 'POST') @method($method) @endif

        @foreach ($fields as $name => $f)
            @php
                [$label, $tipe] = $f;
                $petunjuk = $f[4] ?? null;
                $nilai = $item->exists ? $item->{$name} : ($f[3] ?? '');
                if ($nilai instanceof \DateTimeInterface) { $nilai = $nilai->format('Y-m-d'); }
                $nilai = old($name, $nilai);
                $berkas = ($tipe === 'file' && $item->exists) ? $item->{$name} : null;
                $video = $berkas && ($item->tipe ?? null) === 'video';
                $boleh = (is_string($f[2]) && str_contains($f[2], 'mp4'))
                    ? 'image/jpeg,image/png,image/webp,video/mp4,video/webm' : 'image/jpeg,image/png,image/webp';
            @endphp
            <div class="fld {{ $errors->has($name) ? 'salah' : '' }}">
                <label for="{{ $name }}">{{ $label }}</label>

                @if ($tipe === 'textarea')
                    <textarea id="{{ $name }}" name="{{ $name }}" rows="5">{{ $nilai }}</textarea>

                @elseif ($tipe === 'file')
                    @if ($berkas)
                        @if ($video)
                            <video src="{{ asset('storage/' . $berkas) }}" controls class="pratinjau"></video>
                        @else
                            <img src="{{ asset('storage/' . $berkas) }}" alt="Gambar saat ini" class="pratinjau">
                        @endif
                        <p class="petunjuk petunjuk-file">File saat ini. Pilih file baru untuk menggantinya.</p>
                    @endif
                    <img id="pratinjau-{{ $name }}" alt="Pratinjau" class="pratinjau" hidden>
                    <input id="{{ $name }}" name="{{ $name }}" type="file" accept="{{ $boleh }}" data-pratinjau="pratinjau-{{ $name }}">

                @elseif ($tipe === 'color')
                    <input id="{{ $name }}" name="{{ $name }}" type="color" value="{{ $nilai ?: '#d8f1fb' }}">

                @else
                    <input id="{{ $name }}" name="{{ $name }}" type="{{ $tipe }}" value="{{ $nilai }}">
                @endif

                @if ($petunjuk)<p class="petunjuk">{{ $petunjuk }}</p>@endif
                @error($name)<p class="galat">{{ $message }}</p>@enderror
            </div>
        @endforeach

        <div class="baris-tombol">
            <button type="submit" class="btn btn-biru">Simpan Perubahan</button>
            <a href="{{ $back }}" class="btn btn-garis">Batal</a>
        </div>
    </form>
</div>

<script>
    // Pratinjau gambar yang baru dipilih (sebelum disimpan)
    document.querySelectorAll('input[type=file][data-pratinjau]').forEach((input) => {
        input.addEventListener('change', () => {
            const img = document.getElementById(input.dataset.pratinjau);
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                img.src = URL.createObjectURL(file);
                img.hidden = false;
            } else {
                img.hidden = true;
            }
        });
    });
</script>
@endsection