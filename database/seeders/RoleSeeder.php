<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run():void{
        DB::table('roles')->insert([
            ['role_id' => 1, 'nama_role' => 'Admin'],
            ['role_id' => 2, 'nama_role' => 'Auditor'],
            ['role_id' => 3, 'nama_role' => 'Auditee'],
            ['role_id' => 4, 'nama_role' => 'Kepala'],
        ]);
    }
}
