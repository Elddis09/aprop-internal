<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'username' => 'super_admin',
                'password' => '123456',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Front Office',
                'email' => 'frontOffice@example.com',
                'username' => 'front_office',
                'password' => '123456',
                'role' => 'frontoffice',
            ],
            [
                'name' => 'Back Office',
                'email' => 'backOffice@example.com',
                'username' => 'back_office',
                'password' => '123456',
                'role' => 'backoffice',
            ],
            [
                'name' => 'Staf Pimpinan',
                'email' => 'stafpimpinan@example.com',
                'username' => 'staf_pimpinan',
                'password' => '123456',
                'role' => 'stafpimpinan',
            ],
            [
                'name' => 'Sekretaris Umum',
                'email' => 'sekretarisumum@example.com',
                'username' => 'sekum',
                'password' => '123456',
                'role' => 'sekretarisumum',
            ],
            [
                'name' => 'Staf Binpres',
                'email' => 'stafbinpres@example.com',
                'username' => 'staf_binpres',
                'password' => '123456',
                'role' => 'stafbinpres',
            ],
            [
                'name' => 'Binpres',
                'email' => 'binpres@example.com',
                'username' => 'binpres',
                'password' => '123456',
                'role' => 'binpres',
            ],
            [
                'name' => 'Sekretaris II',
                'email' => 'sekretarisdua@example.com',
                'username' => 'sekretaris_dua',
                'password' => '123456',
                'role' => 'sekretarisdua',
            ],
            [
                'name' => 'Ketua II',
                'email' => 'ketuadua@example.com',
                'username' => 'ketua_dua',
                'password' => '123456',
                'role' => 'ketuadua',
            ],
            [
                'name' => 'Ketua Umum',
                'email' => 'ketuaumum@example.com',
                'username' => 'ketum',
                'password' => '123456',
                'role' => 'ketuaumum',
            ],
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@example.com',
                'username' => 'keuangan',
                'password' => '123456',
                'role' => 'keuangan',
            ],
            [
                'name' => 'BAI',
                'email' => 'bai@example.com',
                'username' => 'bai',
                'password' => '123456',
                'role' => 'bai',
            ],

        ];

        foreach ($users as $userData) {
            // Cek apakah email sudah ada, jika tidak ada baru dibuat
            if (!User::where('email', $userData['email'])->exists()) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'username' => $userData['username'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                ]);
            }
        }
    }
}
