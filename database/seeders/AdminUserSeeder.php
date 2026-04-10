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
            ['email' => 'admin@jobsnepal.com'],
            [
                'name'       => 'Platform Admin',
                'email'      => 'admin@jobsnepal.com',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'company_id' => null,
                'is_active'  => true,
            ]
        );

        $this->command->info('Admin user created: admin@jobsnepal.com / password');
    }
}
