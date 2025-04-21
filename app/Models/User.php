<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['role_id', 'unit_kerja_id', 'email', 'password', 'nama', 'nip'];

    // Relasi: User berelasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Relasi: User berelasi ke UnitKerja
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'unit_kerja_id');
    }

    // Relasi: User sebagai auditor pertama di Auditing
    public function auditor1Auditings()
    {
        return $this->hasMany(Auditing::class, 'user_id_1_auditor', 'user_id');
    }

    // Relasi: User sebagai auditor kedua di Auditing
    public function auditor2Auditings()
    {
        return $this->hasMany(Auditing::class, 'user_id_2_auditor', 'user_id');
    }

    // Relasi: User sebagai auditee pertama di Auditing
    public function auditee1Auditings()
    {
        return $this->hasMany(Auditing::class, 'user_id_1_auditee', 'user_id');
    }

    // Relasi: User sebagai auditee kedua di Auditing
    public function auditee2Auditings()
    {
        return $this->hasMany(Auditing::class, 'user_id_2_auditee', 'user_id');
    }
}
