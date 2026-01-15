<?php

// database\migrations\2026_01_12_060242_add_photo_processing_fields_to_listing_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            // Tambah compressed_path untuk safety
            if (! Schema::hasColumn('listing_photos', 'compressed_path')) {
                $table->string('compressed_path')->nullable()->after('path');
            }

            // Tambah processing status
            if (! Schema::hasColumn('listing_photos', 'processing_status')) {
                $table->enum('processing_status', ['pending', 'processing', 'completed', 'failed'])
                    ->default('pending')
                    ->after('compressed_path');
            }

            // Tambah original_size untuk tracking
            if (! Schema::hasColumn('listing_photos', 'original_size_kb')) {
                $table->integer('original_size_kb')->nullable()->after('processing_status');
            }

            // Tambah compressed_size untuk analytics
            if (! Schema::hasColumn('listing_photos', 'compressed_size_kb')) {
                $table->integer('compressed_size_kb')->nullable()->after('original_size_kb');
            }
        });
    }

    public function down()
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            $columns = ['compressed_path', 'processing_status', 'original_size_kb', 'compressed_size_kb'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('listing_photos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
