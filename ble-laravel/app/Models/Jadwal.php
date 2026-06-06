<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'kelas',
        'hari',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'id_matkul',
        'id_ruangan',
        'nidn',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_matkul', 'id_matkul');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function mahasiswas()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'jadwal_mahasiswa',
            'id_jadwal',
            'nim'
        );
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_jadwal', 'id_jadwal');
    }
}