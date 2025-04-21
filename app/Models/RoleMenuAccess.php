<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenuAccess extends Model
{
    protected $table = 'role_menu_access';
    protected $primaryKey = 'role_menu_access_id';
    protected $fillable = ['role_id', 'menu_id'];

    // Relasi: RoleMenuAccess berelasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Relasi: RoleMenuAccess berelasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}
