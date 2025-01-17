<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_periksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';
    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function daftarPoli()
    {
        return $this->hasMany(Daftar_poli::class, 'id_jadwal');
    }
}
