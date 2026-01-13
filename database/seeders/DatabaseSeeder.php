<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            VendorSeeder::class,
            ListingsSeeder::class, // 👈 TAMBAH INI
        ]);
    }
}