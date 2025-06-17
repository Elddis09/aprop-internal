<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'superadmin',
            'frontoffice',
            'backoffice',
            'stafpimpinan',
            'sekretarisumum',
            'stafbinpres',
            'binpres',
            'sekretarisdua',
            'ketuadua',
            'ketuaumum',
            'keuangan',
            'bai',
        ];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
