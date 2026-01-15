<?php

// database\migrations\2026_01_11_181444_fix_listings_table_fields.php

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
        Schema::table('listings', function (Blueprint $table) {

            if (! Schema::hasColumn('listings', 'business_name')) {
                $table->string('business_name')->nullable()->after('location');
            }

            if (! Schema::hasColumn('listings', 'year_established')) {
                $table->year('year_established')->nullable()->after('business_name');
            }

            if (! Schema::hasColumn('listings', 'instagram')) {
                $table->string('instagram')->nullable()->after('year_established');
            }

            if (! Schema::hasColumn('listings', 'website')) {
                $table->string('website')->nullable()->after('instagram');
            }

            if (! Schema::hasColumn('listings', 'package_description')) {
                $table->text('package_description')->nullable()->after('description');
            }

            if (! Schema::hasColumn('listings', 'validity_period')) {
                $table->string('validity_period')->nullable()->after('package_description');
            }
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {

            foreach ([
                'business_name',
                'year_established',
                'instagram',
                'website',
                'package_description',
                'validity_period',
            ] as $column) {
                if (Schema::hasColumn('listings', $column)) {
                    $table->dropColumn($column);
                }
            }

        });
    }
};
