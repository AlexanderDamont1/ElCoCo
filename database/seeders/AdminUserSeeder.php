<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@elcoco.com'],
            [
                'name'              => 'Administrador',
                'email'             => 'admin@elcoco.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✓ Usuario admin creado → admin@elcoco.com / password');
    }
}