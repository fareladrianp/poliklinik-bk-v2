<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    protected $table = 'periksa';
    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    public function daftarPoli()
    {
        return $this->belongsTo(Daftar_poli::class, 'id_daftar_poli');
    }

    public function detailPeriksa()
    {
        return $this->hasMany(Detail_periksa::class, 'id_periksa');
    }
}
