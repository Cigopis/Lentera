<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jalankan: php artisan migrate
 *
 * Menambahkan kolom:
 *   - is_visible  (boolean, default true)  → toggle tampil/sembunyikan foto
 *   - sort_order  (integer, default 0)     → urutan tampil foto
 *
 * ke tabel catalog_images.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalog_images', function (Blueprint $table) {
            // Tambahkan setelah kolom is_primary (sesuaikan jika urutan berbeda)
            $table->boolean('is_visible')->default(true)->after('is_primary');
            $table->unsignedInteger('sort_order')->default(0)->after('is_visible');
        });
    }

    public function down(): void
    {
        Schema::table('catalog_images', function (Blueprint $table) {
            $table->dropColumn(['is_visible', 'sort_order']);
        });
    }
};