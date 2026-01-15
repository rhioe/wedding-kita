<?php

// database/seeders/ListingsSeeder.php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListingsSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus dulu semua data agar tidak duplicate
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Listing::truncate();
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==================== BUAT USER VENDOR ====================
        $user = User::firstOrCreate(
            ['email' => 'vendor@demo.com'],
            [
                'name' => 'Demo Vendor',
                'password' => Hash::make('password'),
                'role' => 'vendor',
            ]
        );

        // ==================== BUAT VENDOR PROFILE ====================
        $vendor = Vendor::firstOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => 'Studio Foto Premium',
                'category' => 'Fotografer',
                'location' => 'Jakarta',
                'description' => 'Studio foto profesional untuk pernikahan',
                'year_established' => 2018,
                'whatsapp_number' => '081234567890',
                'instagram' => '@studiopremium',
                'website' => 'https://studiopremium.com',
                'status' => 'active',
                // Slug akan auto-generate oleh model Vendor
            ]
        );

        // ==================== BUAT CATEGORIES ====================
        $categories = [
            'Fotografer',
            'Venue',
            'Catering',
            'Makeup Artist',
            'Wedding Organizer',
            'Dekorasi',
            'Sewa Busana',
            'Videografer',
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName)]
            );
        }

        // ==================== BUAT SAMPLE LISTINGS ====================
        $listingsData = [
            [
                'title' => 'Fotografer Jakarta Premium',
                'description' => 'Paket foto prewedding & wedding day dengan hasil maksimal. Include semua file digital, album, dan canvas print.',
                'price' => 8500000,
                'location' => 'Jakarta Selatan',
                'validity_period' => '6 bulan',
                'package_description' => '• 8 jam shooting • 300+ foto edited • Album hardcover • 2 canvas print • All digital files',
            ],
            [
                'title' => 'Venue Garden Wedding Bogor',
                'description' => 'Venue outdoor dengan taman tropis yang indah. Kapasitas 500 orang, full service catering dan dekorasi.',
                'price' => 35000000,
                'location' => 'Bogor',
                'validity_period' => '1 tahun',
                'package_description' => '• Venue 12 jam • 500 pax • Catering prasmanan • Dekorasi dasar • Sound system',
            ],
            [
                'title' => 'Makeup Artist Bridal Glamour',
                'description' => 'Makeup artist spesialis bride dengan style natural glamour. Include trial makeup dan touch up wedding day.',
                'price' => 3500000,
                'location' => 'Bandung',
                'validity_period' => '3 bulan',
                'package_description' => '• Trial makeup • Wedding day makeup • Touch up • Bawa 1 asisten',
            ],
            [
                'title' => 'Paket Catering Prasmanan 500 Pax',
                'description' => 'Catering prasmanan dengan 8 menu pilihan. Free konsultasi menu, alat makan, dan service staff.',
                'price' => 25000000,
                'location' => 'Tangerang',
                'validity_period' => '6 bulan',
                'package_description' => '• 8 menu prasmanan • 500 porsi • Alat makan • Service staff • Free konsultasi',
            ],
        ];

        foreach ($listingsData as $data) {
            Listing::create(array_merge($data, [
                'vendor_id' => $vendor->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'status' => 'approved',
                'published_at' => now(),
                'is_featured' => rand(0, 1),
                'views_count' => rand(50, 500),
                'whatsapp_clicks' => rand(5, 50),
            ]));
        }

        $this->command->info('✅ Sample data created:');
        $this->command->info('   - 1 Vendor user (vendor@demo.com / password)');
        $this->command->info('   - '.count($categories).' Categories');
        $this->command->info('   - '.count($listingsData).' Listings');
    }
}
