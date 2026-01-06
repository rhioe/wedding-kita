<?php

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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('category')->nullable(); // ✅ BARU: Fotografer, Venue, dll
            $table->text('description');
            $table->decimal('price', 12, 2)->nullable(); // ✅ BARU: Harga
            $table->string('location')->nullable(); // ✅ BARU: Lokasi
            $table->json('photos')->nullable(); // ✅ BARU: Array of photo paths
            $table->integer('thumbnail_index')->default(0); // ✅ BARU: Index foto thumbnail
            $table->string('whatsapp_number')->nullable(); // ✅ BARU: WhatsApp bisnis
            $table->string('instagram')->nullable(); // ✅ BARU: Instagram handle
            $table->string('website')->nullable(); // ✅ BARU: Website/portfolio
            $table->integer('year_established')->nullable(); // ✅ BARU: Tahun berdiri
            $table->string('validity_period')->nullable(); // ✅ BARU: Masa berlaku paket
            $table->text('package_description')->nullable(); // ✅ BARU: Deskripsi paket spesifik
            $table->string('status')->default('pending'); // ✅ BARU: pending/approved/rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};