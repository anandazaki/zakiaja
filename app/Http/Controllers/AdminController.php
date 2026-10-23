<?php

namespace App\Http\Controllers;

use App\Models\{Fasilitas, Galeri, Guru, Jurusan, Kegiatan, Pesan, Prestasi, Profil};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function defs(): array
    {
        return [
            'jurusan' => [
                'model' => Jurusan::class, 'title' => 'Jurusan', 'single' => 'jurusan', 'icon' => 'ðŸŽ“',
                'columns' => ['nama', 'deskripsi'],
                'fields' => [
                    'nama'      => ['Nama jurusan', 'text', 'required|max:150'],
                    'deskripsi' => ['Deskripsi', 'textarea', 'required'],
                    'icon'      => ['Ikon (emoji)', 'text', 'required|max:20', 'ðŸŽ“'],
                    'warna'     => ['Warna latar ikon (contoh: #dbeafe)', 'text', 'required|max:50', '#dbeafe'],
                ],
            ],
            'fasilitas' => [
                'model' => Fasilitas::class, 'title' => 'Sarana dan Prasarana', 'single' => 'sarana', 'icon' => 'ðŸ«',
                'columns' => ['nama'],
                'fields' => [
                    'nama'   => ['Nama sarana', 'text', 'required|max:150'],
                    'icon'   => ['Ikon (emoji)', 'text', 'required|max:20', 'ðŸ«'],
                    'warna1' => ['Warna gradasi awal (contoh: #dbeafe)', 'text', 'required|max:50', '#dbeafe'],
                    'warna2' => ['Warna gradasi akhir (contoh: #bfdbfe)', 'text', 'required|max:50', '#bfdbfe'],
                ],
            ],
            'prestasi' => [
                'model' => Prestasi::class, 'title' => 'Prestasi', 'single' => 'prestasi', 'icon' => 'ðŸ†',
                'columns' => ['judul', 'tahun', 'tingkat'],
                'fields' => [
                    'judul'   => ['Nama prestasi', 'text', 'required|max:200'],
                    'tahun'   => ['Tahun', 'number', 'required|integer|min:1990|max:2100', date('Y')],
                    'tingkat' => ['Tingkat (contoh: Kabupaten)', 'text', 'required|max:100'],
                ],
            ],
            'kegiatan' => [
                'model' => Kegiatan::class, 'title' => 'Kegiatan', 'single' => 'kegiatan', 'icon' => 'ðŸ“…',
                'columns' => ['judul', 'tanggal'],
                'fields' => [
                    'judul'     => ['Nama kegiatan', 'text', 'required|max:200'],
                    'tanggal'   => ['Tanggal', 'date', 'required|date'],
                    'deskripsi' => ['Deskripsi', 'textarea', 'required'],
                    'icon'      => ['Ikon (emoji)', 'text', 'required|max:20', 'ðŸ“…'],
                    'warna1'    => ['Warna gradasi awal (contoh: #dbeafe)', 'text', 'required|max:50', '#dbeafe'],
                    'warna2'    => ['Warna gradasi akhir (contoh: #bfdbfe)', 'text', 'required|max:50', '#bfdbfe'],
                ],
            ],
            'galeri' => [
                'model' => Galeri::class, 'title' => 'Galeri', 'single' => 'foto galeri', 'icon' => 'ðŸ–¼ï¸',
                'columns' => ['judul'],
                'fields' => [
                    'judul'  => ['Judul', 'text', 'required|max:150'],
                    'icon'   => ['Ikon (emoji)', 'text', 'required|max:20', 'ðŸ“·'],
                    'warna1' => ['Warna gradasi awal (contoh: #dbeafe)', 'text', 'required|max:50', '#dbeafe'],
                    'warna2' => ['Warna gradasi akhir (contoh: #bfdbfe)', 'text', 'required|max:50', '#bfdbfe'],
                ],
            ],
            'guru' => [
                'model' => Guru::class, 'title' => 'Data Guru', 'single' => 'guru', 'icon' => 'ðŸ‘©â€ðŸ«',
                'columns' => ['nama', 'mata_pelajaran', 'jabatan', 'nip'],
                'fields' => [
                    'nama'           => ['Nama guru', 'text', 'required|max:150'],
                    'nip'            => ['NIP / NUPTK (boleh kosong)', 'text', 'nullable|max:50'],
                    'mata_pelajaran' => ['Mata pelajaran', 'text', 'required|max:200'],
                    'jabatan'        => ['Jabatan (contoh: Wali Kelas X, boleh kosong)', 'text', 'nullable|max:100'],
                ],
            ],
        ];
    }

    private function def(string $resource): array
    {
        $defs = $this->defs();
        abort_unless(isset($defs[$resource]), 404);

        return $defs[$resource];
    }

    private function rules(array $fields): array
    {
        return collect($fields)->map(fn ($f) => $f[2])->all();
    }

    private function profilFields(): array
    {
        return [
            'nama'      => ['Nama sekolah', 'text', 'required|max:150'],
            'tagline'   => ['Tagline', 'text', 'required|max:255'],
            'deskripsi' => ['Deskripsi sekolah', 'textarea', 'required'],
            'visi'      => ['Visi', 'textarea', 'required'],
            'misi'      => ['Misi (satu poin per baris)', 'textarea', 'required'],
            'sejarah'   => ['Sejarah singkat', 'textarea', 'required'],
            'alamat'    => ['Alamat', 'textarea', 'required'],
            'telepon'   => ['Telepon', 'text', 'required|max:50'],
            'email'     => ['Email', 'email', 'required|email|max:150'],
            'jam_kerja' => ['Jam layanan', 'text', 'required|max:200'],
        ];
    }

    public function dashboard()
    {
        $stats = collect($this->defs())->map(fn ($d, $key) => [
            'key' => $key, 'title' => $d['title'], 'icon' => $d['icon'], 'count' => $d['model']::count(),
        ]);

        return view('admin.dashboard', [
            'stats' => $stats,
            'pesan' => Pesan::count(),
        ]);
    }

    public function profil()
    {
        return view('admin.form', [
            'title'  => 'Profil Sekolah',
            'fields' => $this->profilFields(),
            'item'   => Profil::firstOrFail(),
            'action' => route('admin.profil.update'),
            'method' => 'PUT',
            'back'   => route('admin.dashboard'),
        ]);
    }

    public function profilUpdate(Request $request)
    {
        $data = $request->validate($this->rules($this->profilFields()));
        Profil::firstOrFail()->forceFill($data)->save();

        return redirect()->route('admin.profil')->with('sukses', 'Profil sekolah berhasil disimpan.');
    }

    public function index(string $resource)
    {
        $d = $this->def($resource);

        return view('admin.index', [
            'resource' => $resource,
            'd'        => $d,
            'items'    => $d['model']::orderByDesc('id')->get(),
        ]);
    }

    public function create(string $resource)
    {
        $d = $this->def($resource);

        return view('admin.form', [
            'title'  => 'Tambah ' . $d['single'],
            'fields' => $d['fields'],
            'item'   => new $d['model'],
            'action' => route('admin.data.store', $resource),
            'method' => 'POST',
            'back'   => route('admin.data.index', $resource),
        ]);
    }

    public function store(Request $request, string $resource)
    {
        $d = $this->def($resource);
        $data = $request->validate($this->rules($d['fields']));
        (new $d['model'])->forceFill($data)->save();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil ditambahkan.');
    }

    public function edit(string $resource, int $id)
    {
        $d = $this->def($resource);

        return view('admin.form', [
            'title'  => 'Ubah ' . $d['single'],
            'fields' => $d['fields'],
            'item'   => $d['model']::findOrFail($id),
            'action' => route('admin.data.update', [$resource, $id]),
            'method' => 'PUT',
            'back'   => route('admin.data.index', $resource),
        ]);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $d = $this->def($resource);
        $data = $request->validate($this->rules($d['fields']));
        $d['model']::findOrFail($id)->forceFill($data)->save();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil diperbarui.');
    }

    public function destroy(string $resource, int $id)
    {
        $d = $this->def($resource);
        $d['model']::findOrFail($id)->delete();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil dihapus.');
    }
}
