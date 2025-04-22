<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Hapus data menggunakan delete() untuk menghormati foreign key constraints
        Menu::query()->delete(); // Ini akan memicu ON DELETE CASCADE di role_menu_access
        SubMenu::query()->delete();

        $dashboard = Menu::create([
            'nama_menu' => 'Dashboard',
            'route' => 'dashboard.index',
            'icon' => 'heroicon-o-home',
        ]);

        $periodeAudit = Menu::create([
            'nama_menu' => 'Periode Audit',
            'route' => 'periode-audit.index',
            'icon' => 'heroicon-o-calendar-days',
        ]);

        $jadwalAudit = Menu::create([
            'nama_menu' => 'Jadwal Audit',
            'route' => 'jadwal-audit.index',
            'icon' => 'heroicon-o-clock',
        ]);

        $daftarTilik = Menu::create([
            'nama_menu' => 'Daftar Tilik',
            'route' => 'daftar-tilik.index',
            'icon' => 'heroicon-o-check-circle',
        ]);

        $dataUnit = Menu::create([
            'nama_menu' => 'Data Unit',
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-building-office',
        ]);

        $dataInstrumen = Menu::create([
            'nama_menu' => 'Data Instrumen',
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
        ]);

        $dataUser = Menu::create([
            'nama_menu' => 'Data User',
            'route' => 'data-user.index',
            'icon' => 'heroicon-o-users',
        ]);

        $laporan = Menu::create([
            'nama_menu' => 'Laporan',
            'route' => 'laporan.index',
            'icon' => 'heroicon-o-document-text',
        ]);

        $logout = Menu::create([
            'nama_menu' => 'Logout',
            'route' => 'logout',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
        ]);

        // Submenu untuk Data Unit
        SubMenu::create([
            'nama_sub_menu' => 'Daftar UPT',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-building-office',
            'route_params' => json_encode(['type' => 'upt']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Daftar Prodi',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-academic-cap',
            'route_params' => json_encode(['type' => 'prodi']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Daftar Jurusan',
            'menu_id' => $dataUnit->menu_id,
            'route' => 'unit-kerja.index',
            'icon' => 'heroicon-o-book-open',
            'route_params' => json_encode(['type' => 'jurusan']),
        ]);

        // Submenu untuk Data Instrumen
        SubMenu::create([
            'nama_sub_menu' => 'Instrumen UPT',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'upt']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Instrumen Prodi',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'prodi']),
        ]);

        SubMenu::create([
            'nama_sub_menu' => 'Instrumen Jurusan',
            'menu_id' => $dataInstrumen->menu_id,
            'route' => 'data-instrumen.index',
            'icon' => 'heroicon-o-clipboard-document',
            'route_params' => json_encode(['type' => 'jurusan']),
        ]);
    }
}
