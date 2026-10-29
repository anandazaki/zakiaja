<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tambahan (aman dijalankan di database yang sudah berisi data):
 * hanya MENAMBAH kolom baru, tidak menghapus atau mengubah data lama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profils', function (Blueprint $t) {
            foreach (['hero_judul' => 'string', 'hero_deskripsi' => 'text', 'hero_gambar' => 'string', 'gambar' => 'string'] as $kolom => $tipe) {
                if (! Schema::hasColumn('profils', $kolom)) {
                    $t->{$tipe}($kolom)->nullable();
                }
            }
        });

        Schema::table('fasilitas', function (Blueprint $t) {
            if (! Schema::hasColumn('fasilitas', 'deskripsi')) {
                $t->text('deskripsi')->nullable();
            }
            if (! Schema::hasColumn('fasilitas', 'gambar')) {
                $t->string('gambar')->nullable();
            }
        });

        Schema::table('kegiatans', function (Blueprint $t) {
            if (! Schema::hasColumn('kegiatans', 'gambar')) {
                $t->string('gambar')->nullable();
            }
        });

        Schema::table('galeris', function (Blueprint $t) {
            if (! Schema::hasColumn('galeris', 'file')) {
                $t->string('file')->nullable();
            }
            if (! Schema::hasColumn('galeris', 'tipe')) {
                $t->string('tipe', 10)->default('foto');
            }
        });

        // Isi awal judul & deskripsi banner dari data profil yang sudah ada (hanya jika masih kosong).
        DB::table('profils')->whereNull('hero_judul')->update([
            'hero_judul'     => DB::raw("'Selamat Datang di ' || nama"),
            'hero_deskripsi' => DB::raw('tagline'),
        ]);
    }

    public function down(): void
    {
        // Sengaja dikosongkan agar rollback tidak menghapus konten/gambar yang sudah diisi admin.
    }
};