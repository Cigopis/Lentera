<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Jika kolom status bertipe ENUM, ubah dulu definisinya
        // Jika bertipe VARCHAR/string biasa, migration ini tidak perlu — langsung skip
        DB::statement("ALTER TABLE auction_catalogs MODIFY COLUMN status ENUM('draft','active','sold','closed') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        // Pastikan data sold di-rollback dulu sebelum drop nilai enum
        DB::table('auction_catalogs')->where('status', 'sold')->update(['status' => 'closed']);
        DB::statement("ALTER TABLE auction_catalogs MODIFY COLUMN status ENUM('draft','active','closed') NOT NULL DEFAULT 'draft'");
    }
};