<?php
// database\migrations\2026_01_05_153627_create_vendors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->integer('years_experience')->default(0);
            $table->string('profile_photo')->nullable();
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};