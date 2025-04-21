<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditing extends Model
{
    protected $table = 'auditings';
    protected $primaryKey = 'auditing_id';
    protected $fillable = [
        'user_id_1_auditor',
        'user_id_2_auditor',
        'user_id_1_auditee',
        'user_id_2_auditee',
        'unit_kerja_id',
        'periode_id',
        'status',
    ];

    // Relasi: Auditing berelasi ke User sebagai auditor pertama
    public function auditor1()
    {
        return $this->belongsTo(User::class, 'user_id_1_auditor', 'user_id');
    }

    // Relasi: Auditing berelasi ke User sebagai auditor kedua
    public function auditor2()
    {
        return $this->belongsTo(User::class, 'user_id_2_auditor', 'user_id');
    }

    // Relasi: Auditing berelasi ke User sebagai auditee pertama
    public function auditee1()
    {
        return $this->belongsTo(User::class, 'user_id_1_auditee', 'user_id');
    }

    // Relasi: Auditing berelasi ke User sebagai auditee kedua
    public function auditee2()
    {
        return $this->belongsTo(User::class, 'user_id_2_auditee', 'user_id');
    }

    // Relasi: Auditing berelasi ke UnitKerja
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'unit_kerja_id');
    }

    // Relasi: Auditing berelasi ke PeriodeAudit
    public function periode()
    {
        return $this->belongsTo(PeriodeAudit::class, 'periode_id', 'periode_id');
    }
}
