<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';
    protected $primaryKey = 'id_ruangan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ruangan',
        'nama_ruangan',
        'beacon_uuid',
        'beacon_name',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_ruangan', 'id_ruangan');
    }
}