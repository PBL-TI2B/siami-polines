<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeAudit extends Model
{
    protected $table = 'periode_audits';
    protected $primaryKey = 'periode_id';
    protected $fillable = ['nama_periode', 'tanggal_mulai', 'tanggal_berakhir', 'status'];

    // Pastikan kolom tanggal dikonversi ke Carbon
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    // Relasi: PeriodeAudit memiliki banyak Auditing
    public function auditings()
    {
        return $this->hasMany(Auditing::class, 'periode_id', 'periode_id');
    }
}
