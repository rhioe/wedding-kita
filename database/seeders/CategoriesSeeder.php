<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Fotografer Pernikahan', 'slug' => 'fotografer-pernikahan', 'icon' => 'fa-camera', 'order' => 1],
            ['name' => 'Venue / Gedung Pernikahan', 'slug' => 'venue-gedung', 'icon' => 'fa-building', 'order' => 2],
            ['name' => 'Catering & Prasmanan', 'slug' => 'catering-prasmanan', 'icon' => 'fa-utensils', 'order' => 3],
            ['name' => 'Dekorasi & Florist', 'slug' => 'dekorasi-florist', 'icon' => 'fa-leaf', 'order' => 4],
            ['name' => 'Makeup Artist (MUA)', 'slug' => 'makeup-artist', 'icon' => 'fa-paint-brush', 'order' => 5],
            ['name' => 'Gaun & Jas Pengantin', 'slug' => 'gaun-jas-pengantin', 'icon' => 'fa-tshirt', 'order' => 6],
            ['name' => 'Wedding Organizer', 'slug' => 'wedding-organizer', 'icon' => 'fa-calendar-check', 'order' => 7],
            ['name' => 'Katering & Kue Pengantin', 'slug' => 'katering-kue', 'icon' => 'fa-birthday-cake', 'order' => 8],
            ['name' => 'Sound System & Band', 'slug' => 'sound-system-band', 'icon' => 'fa-music', 'order' => 9],
            ['name' => 'Videografer', 'slug' => 'videografer', 'icon' => 'fa-video', 'order' => 10],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
