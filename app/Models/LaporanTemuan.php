<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTemuan extends Model
{
    protected $table = 'laporan_temuan';
    protected $primaryKey = 'laporan_temuan_id';
    protected $fillable = ['auditing_id', 'uraian_temuan', 'kategori_temuan', 'saran_perbaikan'];

    public function kriterias()
    {
        return $this->belongsToMany(Kriteria::class, 'laporan_temuan_kriteria', 'laporan_temuan_id', 'kriteria_id');
    }

    public function auditing()
    {
        return $this->belongsTo(Auditing::class, 'auditing_id');
    }
}

