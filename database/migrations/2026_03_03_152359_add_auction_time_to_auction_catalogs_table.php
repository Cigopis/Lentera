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
            $table->time('auction_time')->nullable()->after('auction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auction_catalogs', function (Blueprint $table) {
            $table->time('auction_time')->nullable()->after('auction_date');
        });
    }
};
