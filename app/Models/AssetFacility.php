<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'name',
    ];

    /**
     * Relasi ke AuctionCatalog
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(AuctionCatalog::class, 'catalog_id');
    }
}