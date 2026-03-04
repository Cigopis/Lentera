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
        Schema::create('payment_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catalog_id')->constrained('auction_catalogs')->onDelete('cascade');
            $table->string('user_name'); // Nama peserta lelang
            $table->string('user_email'); // Email peserta
            $table->string('user_phone'); // No. Telepon peserta
            $table->enum('payment_type', ['ujl', 'pelunasan']); // Jenis pembayaran
            $table->string('proof_image'); // Path gambar bukti
            $table->decimal('amount', 15, 2)->nullable(); // Nominal pembayaran
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_proofs');
    }
};
