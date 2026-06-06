<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mahasiswa extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'kelas',
        'semester',
        'prodi',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'semester' => 'integer',
    ];

    public function jadwals()
    {
        return $this->belongsToMany(
            Jadwal::class,
            'jadwal_mahasiswa',
            'nim',
            'id_jadwal'
        );
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'nim', 'nim');
    }
}