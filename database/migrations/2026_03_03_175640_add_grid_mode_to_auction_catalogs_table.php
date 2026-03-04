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
            $table->string('grid_mode')
                ->default('main+3')
                ->after('auction_time');
        });
    }

    public function down(): void
    {
        Schema::table('auction_catalogs', function (Blueprint $table) {
            $table->dropColumn('grid_mode');
        });
    }
};
