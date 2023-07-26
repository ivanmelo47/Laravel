<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',
            ],
            // Vendedor
            [
                'name' => 'Vendedor',
                'username' => 'vendedor',
                'email' => 'vendedor@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'vendedor',
                'status' => 'active',
            ],
            // Usuario
            [
                'name' => 'Usuario',
                'username' => 'usuario',
                'email' => 'usuario@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'usuario',
                'status' => 'active',
            ],
        ]);
    }
}
