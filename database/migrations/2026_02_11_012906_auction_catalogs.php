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
        Schema::create('auction_catalogs', function (Blueprint $table) {
        $table->id();
        $table->string('catalog_code', 50)->unique();
        $table->string('shop_number', 50)->nullable();

        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->foreignId('sub_category_id')->constrained()->cascadeOnDelete();
        $table->foreignId('city_id')->constrained()->cascadeOnDelete();

        $table->foreignId('created_by')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();

        $table->decimal('reserve_price', 15, 2)->nullable();
        $table->decimal('deposit_amount', 15, 2)->nullable();

        $table->text('address')->nullable();
        $table->date('auction_date')->nullable();
        $table->string('official_auction_url')->nullable();

        $table->enum('status', ['draft','active','closed'])->default('draft');
        $table->boolean('is_featured')->default(false);

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_catalogs');
    }

};
