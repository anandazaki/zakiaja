@extends('layouts.admin')
@section('title', $d['title'])

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-2xl font-extrabold text-navy">{{ $d['title'] }}</h1>
    <a href="{{ route('admin.data.create', $resource) }}" class="bg-brand hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-lg transition">+ Tambah {{ $d['single'] }}</a>
</div>

<div class="mt-6 bg-white rounded-xl border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-slate-50 text-navy">
            <tr>
                @foreach ($d['columns'] as $c)
                    <th class="px-4 py-3 font-bold">{{ $d['fields'][$c][0] ?? ucfirst($c) }}</th>
                @endforeach
                <th class="px-4 py-3 font-bold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($items as $item)
                <tr>
                    @foreach ($d['columns'] as $c)
                        @php $v = $item->{$c}; @endphp
                        <td class="px-4 py-3 align-top">
                            {{ $v instanceof \DateTimeInterface ? $v->format('d-m-Y') : \Illuminate\Support\Str::limit((string) $v, 80) }}
                        </td>
                    @endforeach
                    <td class="px-4 py-3 whitespace-nowrap text-right">
                        <a href="{{ route('admin.data.edit', [$resource, $item->id]) }}" class="text-brand font-semibold hover:underline">Ubah</a>
                        <form method="POST" action="{{ route('admin.data.destroy', [$resource, $item->id]) }}" class="inline"
                              onsubmit="return confirm('Hapus data ini? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf @method('DELETE')
                            <button class="ml-3 text-red-600 font-semibold hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($d['columns']) + 1 }}" class="px-4 py-10 text-center text-slate-500">Belum ada data. Klik "Tambah {{ $d['single'] }}" untuk mengisi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection