<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mulangverse.id'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('admin12345'),
                'role'     => 'admin',
                'xp'       => 0,
                'level'    => 1,
            ]
        );

        $this->command->info('✅ Admin dibuat:');
        $this->command->info('   Email    : admin@mulangverse.id');
        $this->command->info('   Password : admin12345');
        $this->command->info('   Role     : admin');
    }
}