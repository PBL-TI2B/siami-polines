<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPtpp extends Model
{
    protected $table = 'laporan_ptpp';

    protected $fillable = [
        'standar',
        'uraian_temuan',
        'kategori_temuan',
        'saran_perbaikan',
    ];

    public $timestamps = false; // Menonaktifkan timestamps
}
