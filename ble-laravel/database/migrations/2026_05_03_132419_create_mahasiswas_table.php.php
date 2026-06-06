<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->string('nama');
            $table->string('kelas', 15);
            $table->unsignedTinyInteger('semester');
            $table->string('prodi', 100);
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};