<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin (tú)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@heladeria.com',
            'password' => Hash::make('cambiar123'),
            'role' => 'superadmin',
        ]);

        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@heladeria.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Vendedor
        User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@heladeria.com',
            'password' => Hash::make('vendedor123'),
            'role' => 'vendedor',
        ]);

        // Vendedor adicional
        User::create([
            'name' => 'María López',
            'email' => 'maria@heladeria.com',
            'password' => Hash::make('vendedor123'),
            'role' => 'vendedor',
        ]);
    }
}