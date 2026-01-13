<?php
// database\migrations\2026_01_12_112730_update_listing_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            $table->string('compressed_path')->nullable()->after('path');
            $table->decimal('original_size_kb', 8, 2)->nullable()->after('compressed_path');
            $table->string('processing_status')->default('pending')->after('original_size_kb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listing_photos', function (Blueprint $table) {
            //
        });
    }
};
