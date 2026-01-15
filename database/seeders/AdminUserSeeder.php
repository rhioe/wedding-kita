<?php

// database\seeders\AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $existingAdmin = User::where('email', 'admin@weddingkita.com')->first();

        if ($existingAdmin) {
            $this->command->info('Admin user already exists. Updating role to admin...');
            $existingAdmin->update(['role' => 'admin']);

            return;
        }

        // Buat admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@weddingkita.com',
            'whatsapp' => '6281234567890',
            'phone' => '6281234567890',
            'password' => Hash::make('123456a'),
            'role' => 'admin',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@weddingkita.com');
        $this->command->info('Password: 123456a');
    }
}
