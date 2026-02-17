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
        Schema::create('asset_specifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('catalog_id')->constrained('auction_catalogs')->cascadeOnDelete();
        $table->decimal('land_area', 10, 2)->nullable();
        $table->decimal('building_area', 10, 2)->nullable();
        $table->integer('bedrooms')->nullable();
        $table->integer('bathrooms')->nullable();
        $table->integer('floors')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
