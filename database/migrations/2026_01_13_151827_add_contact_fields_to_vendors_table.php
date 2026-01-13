<?php
// database\migrations\2026_01_13_151827_add_contact_fields_to_vendors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Tambah semua field yang belum ada
            if (!Schema::hasColumn('vendors', 'year_established')) {
                $table->integer('year_established')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('vendors', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('year_established');
            }
            
            if (!Schema::hasColumn('vendors', 'instagram')) {
                $table->string('instagram')->nullable()->after('whatsapp_number');
            }
            
            if (!Schema::hasColumn('vendors', 'website')) {
                $table->string('website')->nullable()->after('instagram');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'year_established',
                'whatsapp_number',
                'instagram',
                'website'
            ]);
        });
    }
};