<?php

// database/migrations/2026_01_12_112730_update_listing_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            // Hanya tambah kolom jika belum ada
            if (! Schema::hasColumn('listing_photos', 'original_size_kb')) {
                $table->decimal('original_size_kb', 8, 2)->nullable()->after('compressed_path');
            }

            if (! Schema::hasColumn('listing_photos', 'processing_status')) {
                $table->string('processing_status')->default('pending')->after('original_size_kb');
            }
        });
    }

    public function down(): void
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            // Optional: Hapus jika mau rollback
            // $table->dropColumn(['original_size_kb', 'processing_status']);
        });
    }
};
