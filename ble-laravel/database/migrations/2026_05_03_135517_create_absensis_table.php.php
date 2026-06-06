<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->string('nim', 20);
            $table->unsignedBigInteger('id_jadwal');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'alpha'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('nim')
                  ->references('nim')
                  ->on('mahasiswas')
                  ->cascadeOnDelete();
            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwals')
                  ->cascadeOnDelete();

            // Satu mahasiswa hanya bisa absen sekali per jadwal per hari
            $table->unique(['nim', 'id_jadwal', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};