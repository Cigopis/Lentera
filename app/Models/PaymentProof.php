<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentProof extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'user_name',
        'user_email',
        'user_phone',
        'payment_type',
        'proof_image',
        'amount',
        'notes',
        'status',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Relationship dengan AuctionCatalog
     */
    public function catalog()
    {
        return $this->belongsTo(AuctionCatalog::class, 'catalog_id');
    }

    /**
     * Relationship dengan User (verifier)
     */
    public function verifier()
    {
        return $this->belongsTo(Employee::class, 'verified_by');
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'verified' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get payment type label
     */
    public function getPaymentTypeLabelAttribute()
    {
        return $this->payment_type === 'ujl' 
            ? 'Uang Jaminan Lelang (UJL)' 
            : 'Pelunasan';
    }
}