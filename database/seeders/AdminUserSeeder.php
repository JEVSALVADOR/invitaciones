<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@invitaciones.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin1234!'),
                'role'     => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}
