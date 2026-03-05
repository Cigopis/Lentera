<?php

namespace App\Http\Controllers;

use App\Models\PaymentProof;
use App\Models\AuctionCatalog; // ✅ DIPERBAIKI!
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentProofController extends Controller
{
    /**
     * Store payment proof
     */
    public function store(Request $request, AuctionCatalog $catalog)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_phone' => 'required|string|max:20',
            'payment_type' => 'required|in:ujl,pelunasan',
            'proof_image' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // Max 5MB
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ], [
            'user_name.required' => 'Nama lengkap wajib diisi',
            'user_email.required' => 'Email wajib diisi',
            'user_email.email' => 'Format email tidak valid',
            'user_phone.required' => 'Nomor telepon wajib diisi',
            'payment_type.required' => 'Jenis pembayaran wajib dipilih',
            'proof_image.required' => 'Bukti pembayaran wajib diunggah',
            'proof_image.file' => 'File harus berupa gambar atau PDF',
            'proof_image.mimes' => 'Format file harus: jpeg, png, jpg, atau pdf',
            'proof_image.max' => 'Ukuran file maksimal 5MB',
            'amount.required' => 'Nominal pembayaran wajib diisi',
            'amount.numeric' => 'Nominal pembayaran harus berupa angka',
        ]);

        // Upload file
        $path = $request->file('proof_image')->store('payment-proofs', 'public');

        // Create payment proof record
        $paymentProof = PaymentProof::create([
            'catalog_id' => $catalog->id,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
            'payment_type' => $request->payment_type,
            'proof_image' => $path,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Tim kami akan segera memverifikasi.');
    }

    /**
     * Check user payment status
     * ✅ DIPERBAIKI: Pakai AuctionCatalog
     */
    public function checkStatus(Request $request, AuctionCatalog $catalog)
    {
        $request->validate([
            'user_email' => 'required|email',
        ]);

        $proofs = PaymentProof::where('catalog_id', $catalog->id)
            ->where('user_email', $request->user_email)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'found' => $proofs->count() > 0,
            'proofs' => $proofs,
        ]);
    }
}