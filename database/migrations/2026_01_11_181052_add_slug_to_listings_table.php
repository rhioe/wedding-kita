<?php
// database\migrations\2026_01_11_181052_add_slug_to_listings_table.php

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
        $table->string('slug')->after('title');
    });
}

public function down()
{
    Schema::table('listings', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}



};
