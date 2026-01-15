<?php

// database/migrations/2026_01_09_061313_fix_listings_table_structure.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // 1. DROP kolom yang redundant (OLD WAY)
            $table->dropColumn(['photos', 'thumbnail_index']);

            // 2. RENAME category ke category_old (backup old data)
            $table->renameColumn('category', 'category_old');

            // 3. Note: category_id sudah ada, jadi tidak perlu dibuat lagi
        });

        // 4. (Optional) Migrate data dari category_old ke category_id
        // Kita bisa lakukan di sini atau nanti dengan seeder
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Reverse changes
            $table->json('photos')->nullable();
            $table->integer('thumbnail_index')->default(0);
            $table->renameColumn('category_old', 'category');
        });
    }
};
