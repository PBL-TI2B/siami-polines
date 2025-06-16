<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria'; // Nama tabel sesuai migrasi
    protected $primaryKey = 'kriteria_id'; // Primary key sesuai migrasi
    protected $fillable = ['nama_kriteria']; // Kolom yang dapat diisi, sesuaikan dengan kebutuhan

    // Relasi many-to-many dengan LaporanTemuan
    public function laporanTemuans()
    {
        return $this->belongsToMany(LaporanTemuan::class, 'laporan_temuan_kriteria', 'kriteria_id', 'laporan_temuan_id');
    }
}
