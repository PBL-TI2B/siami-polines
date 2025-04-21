<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['nama_role'];
    public $timestamps = false; // Sesuaikan dengan kebutuhan


    // Relasi: Role memiliki banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    // Relasi: Role memiliki banyak RoleMenuAccess
    public function roleMenuAccesses()
    {
        return $this->hasMany(RoleMenuAccess::class, 'role_id', 'role_id');
    }
}
