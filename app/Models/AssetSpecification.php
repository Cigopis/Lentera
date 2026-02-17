<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'land_area',
        'building_area',
        'bedrooms',
        'bathrooms',
        'floors',
    ];

    protected $casts = [
        'land_area' => 'decimal:2',
        'building_area' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floors' => 'integer',
    ];

    /**
     * Relasi ke AuctionCatalog
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(AuctionCatalog::class, 'catalog_id');
    }

    /**
     * Get formatted land area
     */
    public function getFormattedLandAreaAttribute(): ?string
    {
        return $this->land_area ? number_format($this->land_area, 0, ',', '.') . ' m²' : null;
    }

    /**
     * Get formatted building area
     */
    public function getFormattedBuildingAreaAttribute(): ?string
    {
        return $this->building_area ? number_format($this->building_area, 0, ',', '.') . ' m²' : null;
    }
}