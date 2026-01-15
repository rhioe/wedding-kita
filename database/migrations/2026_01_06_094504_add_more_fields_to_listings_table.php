<?php

// database\migrations\2026_01_06_094504_add_more_fields_to_listings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Tambah columns yang belum ada
            if (! Schema::hasColumn('listings', 'category')) {
                $table->string('category')->nullable()->after('title');
            }

            if (! Schema::hasColumn('listings', 'thumbnail_index')) {
                $table->integer('thumbnail_index')->default(0)->after('photos');
            }

            if (! Schema::hasColumn('listings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('thumbnail_index');
            }

            if (! Schema::hasColumn('listings', 'instagram')) {
                $table->string('instagram')->nullable()->after('whatsapp_number');
            }

            if (! Schema::hasColumn('listings', 'website')) {
                $table->string('website')->nullable()->after('instagram');
            }

            if (! Schema::hasColumn('listings', 'year_established')) {
                $table->integer('year_established')->nullable()->after('website');
            }

            if (! Schema::hasColumn('listings', 'validity_period')) {
                $table->string('validity_period')->nullable()->after('year_established');
            }

            if (! Schema::hasColumn('listings', 'package_description')) {
                $table->text('package_description')->nullable()->after('validity_period');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Hapus columns jika rollback
            $table->dropColumn([
                'category',
                'thumbnail_index',
                'whatsapp_number',
                'instagram',
                'website',
                'year_established',
                'validity_period',
                'package_description',
            ]);
        });
    }
};
