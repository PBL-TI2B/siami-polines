<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::query()->delete();

        Role::create(['nama_role' => 'Admin']);
        Role::create(['nama_role' => 'Admin Unit']);
        Role::create(['nama_role' => 'Auditor']);
        Role::create(['nama_role' => 'Auditee']);
        Role::create(['nama_role' => 'Kepala PMPP']);
    }
}
