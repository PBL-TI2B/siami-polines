<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodeAudit extends Model
{
    use HasFactory;

    protected $table = 'periode_audits';

    protected $primaryKey = 'periode_id';

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}
