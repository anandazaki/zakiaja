<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('tagline');
            $t->text('deskripsi');
            $t->text('visi');
            $t->text('misi');
            $t->text('sejarah');
            $t->string('alamat');
            $t->string('telepon');
            $t->string('email');
            $t->string('jam_kerja');
            $t->timestamps();
        });

        Schema::create('jurusans', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->text('deskripsi');
            $t->string('icon', 10);
            $t->string('warna', 7);
            $t->timestamps();
        });

        Schema::create('fasilitas', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('icon', 10);
            $t->string('warna1', 7);
            $t->string('warna2', 7);
            $t->timestamps();
        });

        Schema::create('prestasis', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->unsignedSmallInteger('tahun');
            $t->string('tingkat');
            $t->timestamps();
        });

        Schema::create('kegiatans', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->date('tanggal');
            $t->text('deskripsi');
            $t->string('icon', 10);
            $t->string('warna1', 7);
            $t->string('warna2', 7);
            $t->timestamps();
        });

        Schema::create('galeris', function (Blueprint $t) {
            $t->id();
            $t->string('judul');
            $t->string('icon', 10);
            $t->string('warna1', 7);
            $t->string('warna2', 7);
            $t->timestamps();
        });

        Schema::create('pesans', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('email');
            $t->text('pesan');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['pesans', 'galeris', 'kegiatans', 'prestasis', 'fasilitas', 'jurusans', 'profils'] as $tabel) {
            Schema::dropIfExists($tabel);
        }
    }
};