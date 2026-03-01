<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('USUARIO')->insert([
            [
                'nombre' => 'Ana',
                'rol' => 'admin',
                'apellidos' => 'García López',
                'email' => 'ana.garcia@email.com',
                'password' => Hash::make('password123'),
                'telefono' => '612345678',
                'activo' => true,
            ],
            [
                'nombre' => 'Carlos',
                'rol' => 'user',
                'apellidos' => 'Martínez Ruiz',
                'email' => 'carlos.martinez@email.com',
                'password' => Hash::make('password123'),
                'telefono' => '623456789',
                'activo' => true,
            ],
            [
                'nombre' => 'Laura',
                'rol' => 'user',
                'apellidos' => 'Fernández Díaz',
                'email' => 'laura.fernandez@email.com',
                'password' => Hash::make('password123'),
                'telefono' => '634567890',
                'activo' => true,
            ],
            [
                'nombre' => 'Pedro',
                'rol' => 'user',
                'apellidos' => 'Sánchez Torres',
                'email' => 'pedro.sanchez@email.com',
                'password' => Hash::make('password123'),
                'telefono' => '645678901',
                'activo' => false,
            ],
            [
                'nombre' => 'María',
                'rol' => 'user',
                'apellidos' => 'López Navarro',
                'email' => 'maria.lopez@email.com',
                'password' => Hash::make('password123'),
                'telefono' => '656789012',
                'activo' => true,
            ],
        ]);
    }
}
