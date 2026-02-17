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
        Schema::create('auction_link_clicks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('catalog_id')->constrained('auction_catalogs')->cascadeOnDelete();
        $table->string('ip_address', 45);
        $table->timestamp('clicked_at')->useCurrent();
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
