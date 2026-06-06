<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->string('kelas', 20)
                  ->after('id_jadwal')
                  ->comment('Kelas yang mengikuti jadwal ini, contoh: IF4C-Pagi');
        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });
    }
};