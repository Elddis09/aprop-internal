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

            // Tambahkan user lainnya sesuai kebutuhan
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
