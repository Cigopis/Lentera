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
        Schema::table('auction_catalogs', function (Blueprint $table) {
            // Menambahkan kolom spesifikasi properti
            $table->decimal('land_area', 10, 2)->nullable()->after('address'); // Luas Tanah
            $table->decimal('building_area', 10, 2)->nullable()->after('land_area'); // Luas Bangunan
            $table->integer('bedrooms')->nullable()->after('building_area'); // Kamar Tidur
            $table->integer('bathrooms')->nullable()->after('bedrooms'); // Kamar Mandi
            $table->integer('floors')->nullable()->after('bathrooms'); // Jumlah Lantai
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auction_catalogs', function (Blueprint $table) {
            $table->dropColumn([
                'land_area',
                'building_area',
                'bedrooms',
                'bathrooms',
                'floors'
            ]);
        });
    }
};
