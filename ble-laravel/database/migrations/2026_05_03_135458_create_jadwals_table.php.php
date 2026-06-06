<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->string('hari', 10);
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->foreignId('id_matkul')
                ->constrained('mata_kuliahs', 'id_matkul')
                ->cascadeOnDelete();
            $table->string('id_ruangan', 20);
            $table->foreign('id_ruangan')
                ->references('id_ruangan')
                ->on('ruangans')
                ->cascadeOnDelete();
            $table->string('nidn', 20);
            $table->foreign('nidn')
                ->references('nidn')
                ->on('dosens')
                ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('jadwal_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jadwal');
            $table->string('nim', 20);
            $table->foreign('id_jadwal')
                ->references('id_jadwal')
                ->on('jadwals')
                ->cascadeOnDelete();
            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswas')
                ->cascadeOnDelete();
            $table->unique(['id_jadwal', 'nim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_mahasiswa');
        Schema::dropIfExists('jadwals');
    }
};