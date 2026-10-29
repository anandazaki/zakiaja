<?php

namespace App\Http\Controllers;

use App\Models\{Fasilitas, Galeri, Guru, Jurusan, Kegiatan, Prestasi, Profil};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private const GAMBAR = 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096';

    /**
     * Definisi data berbentuk daftar (tambah / ubah / hapus).
     * Format field: nama => [label, tipe, aturan validasi, nilai awal (opsional), petunjuk (opsional)]
     * Kolom NOT NULL yang tidak perlu diisi admin (ikon/warna) diisi lewat 'defaults'.
     */
    private function defs(): array
    {
        return [
            'jurusan' => [
                'model' => Jurusan::class, 'title' => 'Kelola Jurusan', 'single' => 'jurusan', 'ikon' => 'jurusan',
                'subtitle' => 'Tambah, edit, atau hapus data jurusan.',
                'columns' => ['nama', 'deskripsi'],
                'fields' => [
                    'nama'      => ['Nama jurusan', 'text', 'required|max:150'],
                    'deskripsi' => ['Deskripsi', 'textarea', 'required'],
                    'icon'      => ['Ikon (emoji)', 'text', 'required|max:10', '🎓', 'Tampil sebagai ikon jurusan di website.'],
                    'warna'     => ['Warna latar ikon', 'color', ['required', 'regex:/^#[0-9a-fA-F]{6}$/'], '#d8f1fb'],
                ],
                'defaults' => [],
            ],
            'fasilitas' => [
                'model' => Fasilitas::class, 'title' => 'Kelola Sarana dan Prasarana', 'single' => 'fasilitas', 'ikon' => 'fasilitas',
                'subtitle' => 'Tambah, edit, atau hapus data sarana dan prasarana sekolah.',
                'columns' => ['nama', 'deskripsi'], 'thumb' => 'gambar',
                'fields' => [
                    'nama'      => ['Nama fasilitas', 'text', 'required|max:150'],
                    'deskripsi' => ['Deskripsi', 'textarea', 'nullable'],
                    'gambar'    => ['Foto fasilitas', 'file', self::GAMBAR, null, 'JPG, PNG, atau WEBP. Maksimal 4 MB.'],
                ],
                'defaults' => ['icon' => '🏫', 'warna1' => '#dbeafe', 'warna2' => '#bfdbfe'],
            ],
            'prestasi' => [
                'model' => Prestasi::class, 'title' => 'Kelola Prestasi', 'single' => 'prestasi', 'ikon' => 'prestasi',
                'subtitle' => 'Tambah, edit, atau hapus data prestasi siswa.',
                'columns' => ['tahun', 'judul', 'tingkat'],
                'fields' => [
                    'judul'   => ['Nama prestasi', 'text', 'required|max:200'],
                    'tahun'   => ['Tahun', 'number', 'required|integer|min:1990|max:2100', date('Y')],
                    'tingkat' => ['Tingkat prestasi', 'text', 'required|max:100', null, 'Contoh: Kabupaten, Provinsi, Nasional.'],
                ],
                'defaults' => [],
            ],
            'kegiatan' => [
                'model' => Kegiatan::class, 'title' => 'Kelola Kegiatan', 'single' => 'kegiatan', 'ikon' => 'kegiatan',
                'subtitle' => 'Tambah, edit, atau hapus data kegiatan sekolah.',
                'columns' => ['judul', 'tanggal'], 'thumb' => 'gambar',
                'fields' => [
                    'judul'     => ['Nama kegiatan', 'text', 'required|max:200'],
                    'tanggal'   => ['Tanggal', 'date', 'required|date'],
                    'deskripsi' => ['Deskripsi', 'textarea', 'required'],
                    'gambar'    => ['Foto kegiatan', 'file', self::GAMBAR, null, 'JPG, PNG, atau WEBP. Maksimal 4 MB.'],
                ],
                'defaults' => ['icon' => '📅', 'warna1' => '#dbeafe', 'warna2' => '#bfdbfe'],
            ],
            'galeri' => [
                'model' => Galeri::class, 'title' => 'Kelola Galeri', 'single' => 'foto/video', 'ikon' => 'galeri',
                'subtitle' => 'Unggah, tampilkan, atau hapus foto dan video.',
                'columns' => ['judul'], 'thumb' => 'file',
                'fields' => [
                    'judul' => ['Judul / keterangan', 'text', 'required|max:150'],
                    'file'  => ['Foto atau video', 'file', 'required|file|mimes:jpg,jpeg,png,webp,mp4,webm|max:20480', null, 'JPG, PNG, WEBP, MP4, atau WEBM. Maksimal 20 MB.'],
                ],
                'defaults' => ['icon' => '📷', 'warna1' => '#dbeafe', 'warna2' => '#bfdbfe'],
            ],
            'guru' => [
                'model' => Guru::class, 'title' => 'Data Guru', 'single' => 'guru', 'ikon' => 'guru',
                'subtitle' => 'Tambah, edit, atau hapus data guru.',
                'columns' => ['nama', 'mata_pelajaran', 'jabatan', 'nip'],
                'fields' => [
                    'nama'           => ['Nama guru', 'text', 'required|max:150'],
                    'nip'            => ['NIP / NUPTK (boleh kosong)', 'text', 'nullable|max:50'],
                    'mata_pelajaran' => ['Mata pelajaran', 'text', 'required|max:200'],
                    'jabatan'        => ['Jabatan (boleh kosong)', 'text', 'nullable|max:100'],
                ],
                'defaults' => [],
            ],
        ];
    }

    /** Halaman tunggal (satu baris data pada tabel profils). */
    private function halamanDefs(): array
    {
        return [
            'beranda' => [
                'title' => 'Edit Halaman Beranda', 'subtitle' => 'Ubah konten pada halaman utama website.',
                'folder' => 'beranda',
                'fields' => [
                    'hero_gambar'    => ['Banner utama', 'file', self::GAMBAR, null, 'Ukuran disarankan: 1920 x 800 px. Maksimal 4 MB.'],
                    'hero_judul'     => ['Judul', 'text', 'required|max:150'],
                    'hero_deskripsi' => ['Deskripsi', 'textarea', 'required'],
                ],
            ],
            'profil' => [
                'title' => 'Edit Profil Sekolah', 'subtitle' => 'Ubah informasi profil, visi, misi, dan foto gedung sekolah.',
                'folder' => 'profil',
                'fields' => [
                    'gambar'    => ['Foto gedung sekolah', 'file', self::GAMBAR, null, 'Ukuran disarankan: 1200 x 600 px. Maksimal 4 MB.'],
                    'nama'      => ['Nama sekolah', 'text', 'required|max:150'],
                    'tagline'   => ['Tagline', 'text', 'required|max:255'],
                    'deskripsi' => ['Deskripsi singkat', 'textarea', 'required'],
                    'visi'      => ['Visi', 'textarea', 'required'],
                    'misi'      => ['Misi (satu poin per baris)', 'textarea', 'required'],
                    'sejarah'   => ['Sejarah singkat', 'textarea', 'required'],
                ],
            ],
            'kontak' => [
                'title' => 'Edit Informasi Kontak', 'subtitle' => 'Ubah informasi kontak sekolah.',
                'folder' => 'kontak',
                'fields' => [
                    'alamat'    => ['Alamat', 'textarea', 'required|max:500'],
                    'telepon'   => ['Telepon', 'text', 'required|max:50'],
                    'email'     => ['Email', 'email', 'required|email|max:150'],
                    'jam_kerja' => ['Jam operasional', 'text', 'required|max:200', null, 'Contoh: Senin–Jumat · 07.00–15.00'],
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

    /**
     * Validasi input lalu simpan file upload ke storage/app/public.
     * File lama dihapus jika diganti. Mengembalikan data siap simpan.
     */
    private function olahInput(Request $request, array $fields, string $folder, bool $ubah, $model = null): array
    {
        $aturan = [];
        foreach ($fields as $nama => $f) {
            $r = $f[2];
            // Saat mengubah data, file tidak wajib diunggah ulang.
            if ($ubah && $f[1] === 'file' && is_string($r)) {
                $r = str_replace('required', 'nullable', $r);
            }
            $aturan[$nama] = $r;
        }

        $data = $request->validate($aturan, [
            'required' => ':attribute wajib diisi.',
            'image'    => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'mimes'    => 'Format file tidak didukung.',
            'max'      => 'Ukuran isian atau file melebihi batas yang diizinkan.',
            'uploaded' => 'File gagal diunggah. Ukuran file mungkin melebihi batas server.',
        ], collect($fields)->map(fn ($f) => strtolower($f[0]))->all());

        foreach ($fields as $nama => $f) {
            if ($f[1] !== 'file') {
                continue;
            }
            unset($data[$nama]);

            if ($request->hasFile($nama)) {
                $path = $request->file($nama)->store($folder, 'public');
                if ($model && $model->{$nama}) {
                    Storage::disk('public')->delete($model->{$nama});
                }
                $data[$nama] = $path;
            }
        }

        return $data;
    }

    private function tipeGaleri(Request $request, array $data): array
    {
        if ($request->hasFile('file')) {
            $data['tipe'] = str_starts_with((string) $request->file('file')->getMimeType(), 'video') ? 'video' : 'foto';
        }

        return $data;
    }

    // ------------------------------------------------------------------ Dashboard

    public function dashboard()
    {
        $defs = $this->defs();
        $kartu = collect(['jurusan', 'fasilitas', 'prestasi', 'kegiatan'])->map(fn ($key) => [
            'key'    => $key,
            'label'  => ucfirst($defs[$key]['single']),
            'ikon'   => $defs[$key]['ikon'],
            'jumlah' => $defs[$key]['model']::count(),
        ]);

        return view('admin.dashboard', ['kartu' => $kartu]);
    }

    // ------------------------------------------------------------------ Halaman tunggal (Beranda, Profil, Kontak)

    private function halaman(string $kunci)
    {
        $h = $this->halamanDefs()[$kunci];

        return view('admin.form', [
            'ikon'     => $kunci,
            'title'    => $h['title'],
            'subtitle' => $h['subtitle'],
            'fields'   => $h['fields'],
            'item'     => Profil::firstOrFail(),
            'action'   => route('admin.' . $kunci . '.update'),
            'method'   => 'PUT',
            'back'     => route('admin.dashboard'),
            'lebar'    => $kunci === 'kontak' ? 'max-w-2xl' : 'max-w-3xl',
        ]);
    }

    private function halamanSimpan(Request $request, string $kunci)
    {
        $h = $this->halamanDefs()[$kunci];
        $profil = Profil::firstOrFail();
        $data = $this->olahInput($request, $h['fields'], $h['folder'], true, $profil);
        $profil->forceFill($data)->save();

        return redirect()->route('admin.' . $kunci)->with('sukses', 'Perubahan berhasil disimpan.');
    }

    public function beranda()
    {
        return $this->halaman('beranda');
    }

    public function berandaUpdate(Request $request)
    {
        return $this->halamanSimpan($request, 'beranda');
    }

    public function profil()
    {
        return $this->halaman('profil');
    }

    public function profilUpdate(Request $request)
    {
        return $this->halamanSimpan($request, 'profil');
    }

    public function kontak()
    {
        return $this->halaman('kontak');
    }

    public function kontakUpdate(Request $request)
    {
        return $this->halamanSimpan($request, 'kontak');
    }

    // ------------------------------------------------------------------ Data berbentuk daftar

    public function index(string $resource)
    {
        $d = $this->def($resource);
        $urut = match ($resource) {
            'prestasi' => ['tahun', 'desc'],
            'kegiatan' => ['tanggal', 'desc'],
            'galeri'   => ['id', 'desc'],
            default    => ['id', 'asc'],
        };

        return view('admin.index', [
            'resource' => $resource,
            'd'        => $d,
            'items'    => $d['model']::orderBy(...$urut)->get(),
        ]);
    }

    public function create(string $resource)
    {
        $d = $this->def($resource);

        return view('admin.form', [
            'ikon'     => $d['ikon'],
            'title'    => 'Tambah ' . ucfirst($d['single']),
            'subtitle' => $d['subtitle'],
            'fields'   => $d['fields'],
            'item'     => new $d['model'],
            'action'   => route('admin.data.store', $resource),
            'method'   => 'POST',
            'back'     => route('admin.data.index', $resource),
            'lebar'    => 'max-w-2xl',
        ]);
    }

    public function store(Request $request, string $resource)
    {
        $d = $this->def($resource);
        $data = $this->olahInput($request, $d['fields'], $resource, false);
        if ($resource === 'galeri') {
            $data = $this->tipeGaleri($request, $data);
        }
        (new $d['model'])->forceFill($d['defaults'] + $data)->save();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil ditambahkan.');
    }

    public function edit(string $resource, int $id)
    {
        $d = $this->def($resource);

        return view('admin.form', [
            'ikon'     => $d['ikon'],
            'title'    => 'Ubah ' . ucfirst($d['single']),
            'subtitle' => $d['subtitle'],
            'fields'   => $d['fields'],
            'item'     => $d['model']::findOrFail($id),
            'action'   => route('admin.data.update', [$resource, $id]),
            'method'   => 'PUT',
            'back'     => route('admin.data.index', $resource),
            'lebar'    => 'max-w-2xl',
        ]);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $d = $this->def($resource);
        $item = $d['model']::findOrFail($id);
        $data = $this->olahInput($request, $d['fields'], $resource, true, $item);
        if ($resource === 'galeri') {
            $data = $this->tipeGaleri($request, $data);
        }
        $item->forceFill($data)->save();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil diperbarui.');
    }

    public function destroy(string $resource, int $id)
    {
        $d = $this->def($resource);
        $item = $d['model']::findOrFail($id);

        foreach ($d['fields'] as $nama => $f) {
            if ($f[1] === 'file' && $item->{$nama}) {
                Storage::disk('public')->delete($item->{$nama});
            }
        }
        $item->delete();

        return redirect()->route('admin.data.index', $resource)->with('sukses', ucfirst($d['single']) . ' berhasil dihapus.');
    }
}