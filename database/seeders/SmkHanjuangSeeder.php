<?php

namespace Database\Seeders;

use App\Models\{Fasilitas, Galeri, Jurusan, Kegiatan, Prestasi, Profil};
use Illuminate\Database\Seeder;

class SmkHanjuangSeeder extends Seeder
{
    public function run(): void
    {
        Profil::create([
            'nama'       => 'SMK Hanjuang',
            'tagline'    => 'Sekolah Unggul & Berkarakter',
            'deskripsi'  => 'SMK Hanjuang berkomitmen memberikan pendidikan yang mengembangkan pengetahuan, keterampilan, karakter, dan kreativitas peserta didik.',
            'visi'       => 'Menjadi sekolah yang unggul dalam prestasi, berkarakter, terampil, dan berdaya saing.',
            'misi'       => "Meningkatkan kualitas pembelajaran.\nMengembangkan kompetensi peserta didik.\nMembentuk siswa yang disiplin dan bertanggung jawab.\nMewujudkan lingkungan sekolah yang aman dan kondusif.",
            'sejarah'    => 'Isi bagian ini dengan sejarah resmi SMK Hanjuang, tahun berdiri, perkembangan sekolah, serta informasi penting lainnya.',
            'alamat'     => 'isi alamat resmi sekolah',
            'telepon'    => '08xxxxxxxxxx',
            'email'      => 'info@smkhanjuang.sch.id',
            'jam_kerja'  => 'Senin–Jumat · 07.00–15.00',
        ]);

        foreach ([
               ['TSM', 'Mempelajari perawatan, perbaikan, dan teknologi sepeda motor.', '🏍️', '#d8f1fb'],
            ['Teknik Komputer & Jaringan', 'Mempelajari komputer, jaringan, dan teknologi informasi.', '🌐', '#fdf0cf'],
            ['Desain Komunikasi Visual', 'Mengembangkan kemampuan desain grafis, multimedia, dan komunikasi visual.', '🎨', '#e8e2fb'],
            ['Manajemen Perkantoran', 'Mempelajari administrasi, pengelolaan dokumen, dan pelayanan perkantoran.', '⚙️', '#d9f5ea'],
        ] as [$nama, $desk, $icon, $warna]) {
            Jurusan::create(['nama' => $nama, 'deskripsi' => $desk, 'icon' => $icon, 'warna' => $warna]);
        }

        foreach ([
            ['Ruang Kelas', '🪑', '#d9f0fb', '#7fbbdc'],
            ['Laboratorium', '🖥️', '#e3effb', '#a9c9e3'],
            ['Perpustakaan', '📚', '#f5e6cc', '#d4b27a'],
            ['Lapangan Olahraga', '⚽', '#d7f0dc', '#7cc08a'],
            ['Ruang Multimedia', '🎬', '#e3dafb', '#a58ed6'],
            ['Tempat Ibadah', '🕌', '#dcf3ec', '#80c9b4'],
        ] as [$nama, $icon, $w1, $w2]) {
            Fasilitas::create(['nama' => $nama, 'icon' => $icon, 'warna1' => $w1, 'warna2' => $w2]);
        }

        foreach ([
            ['Juara 1 Lomba Olimpiade Matematika', 2025, 'Kabupaten'],
            ['Juara 2 Lomba Debat Bahasa Indonesia', 2025, 'Provinsi'],
            ['Juara 1 Lomba Futsal', 2024, 'Kabupaten'],
            ['Juara 3 Karya Ilmiah Remaja', 2024, 'Provinsi'],
        ] as [$judul, $tahun, $tingkat]) {
            Prestasi::create(['judul' => $judul, 'tahun' => $tahun, 'tingkat' => $tingkat]);
        }

        foreach ([
            ['MPLS', '2025-07-15', '🎓', '#bfe6f5', '#4f8fb3', 'Masa Pengenalan Lingkungan Sekolah bagi peserta didik baru.'],
            ['Outbound', '2025-08-20', '🏃', '#c7e6cc', '#5c9b6e', 'Kegiatan outbound untuk membangun kekompakan dan kepemimpinan siswa.'],
            ['Peringatan Hari Guru', '2025-11-25', '🎉', '#fbd9c3', '#c97f5f', 'Peringatan Hari Guru Nasional bersama seluruh warga sekolah.'],
        ] as [$judul, $tgl, $icon, $w1, $w2, $desk]) {
            Kegiatan::create(['judul' => $judul, 'tanggal' => $tgl, 'icon' => $icon, 'warna1' => $w1, 'warna2' => $w2, 'deskripsi' => $desk]);
        }

        foreach ([
            ['Upacara Bendera', '🇮🇩', '#fbd9d9', '#d98b8b'],
            ['Praktik Jurusan', '🛠️', '#d9e8fb', '#7ea6d9'],
            ['Pentas Seni', '🎭', '#e8dcfb', '#a68ad9'],
            ['Kunjungan Industri', '🏭', '#dcf3e4', '#7cc093'],
        ] as [$judul, $icon, $w1, $w2]) {
            Galeri::create(['judul' => $judul, 'icon' => $icon, 'warna1' => $w1, 'warna2' => $w2]);
        }
    }
}