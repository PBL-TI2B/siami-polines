<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerja';
    protected $primaryKey = 'unit_kerja_id';
    protected $fillable = ['nama_unit_kerja', 'parent_id', 'jenis_unit_id'];
    public $timestamps = false; // Sesuaikan dengan kebutuhan

    // Relasi: UnitKerja berelasi ke JenisUnit
    public function jenisUnit()
    {
        return $this->belongsTo(JenisUnit::class, 'jenis_unit_id', 'jenis_unit_id');
    }

    // Relasi: UnitKerja memiliki banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'unit_kerja_id', 'unit_kerja_id');
    }

    // Relasi: UnitKerja memiliki banyak Auditing
    public function auditings()
    {
        return $this->hasMany(Auditing::class, 'unit_kerja_id', 'unit_kerja_id');
    }

    // Relasi: UnitKerja berelasi ke parent UnitKerja (self-referential)
    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id', 'unit_kerja_id');
    }

    // Relasi: UnitKerja memiliki banyak children UnitKerja (self-referential)
    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id', 'unit_kerja_id');
    }
}
