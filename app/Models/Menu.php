<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'menu_id';
    protected $fillable = ['nama_menu', 'route', 'icon'];
    public $timestamps = false; // Sesuaikan dengan kebutuhan

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class, 'menu_id', 'menu_id');
    }
}
