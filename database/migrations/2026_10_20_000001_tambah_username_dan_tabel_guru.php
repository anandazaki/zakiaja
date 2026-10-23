<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $t) {
                $t->string('username')->nullable()->unique();
            });
        }

        if (! Schema::hasTable('gurus')) {
            Schema::create('gurus', function (Blueprint $t) {
                $t->id();
                $t->string('nama');
                $t->string('nip')->nullable();
                $t->string('mata_pelajaran');
                $t->string('jabatan')->nullable();
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};