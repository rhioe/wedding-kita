<?php

// database/migrations/2026_01_13_143831_add_blueprint_fields_to_listings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Hanya tambah jika belum ada
            if (! Schema::hasColumn('listings', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('title');
            }

            if (! Schema::hasColumn('listings', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('status');
            }

            if (! Schema::hasColumn('listings', 'views_count')) {
                $table->integer('views_count')->default(0)->after('published_at');
            }

            if (! Schema::hasColumn('listings', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('views_count');
            }

            if (! Schema::hasColumn('listings', 'whatsapp_clicks')) {
                $table->integer('whatsapp_clicks')->default(0)->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Optional rollback
            // $table->dropColumn(['slug', 'published_at', 'views_count', 'is_featured', 'whatsapp_clicks']);
        });
    }
};
