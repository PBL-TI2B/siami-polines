<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'sub_menus';
    protected $primaryKey = 'sub_menu_id';
    protected $fillable = ['nama_sub_menu', 'menu_id', 'route', 'icon'];
    public $timestamps = false; // Sesuaikan dengan kebutuhan

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}
