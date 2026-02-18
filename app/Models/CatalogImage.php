<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogImage extends Model
{
    protected $fillable = [
        'catalog_id',
        'image_path',
        'display_order',
        'is_primary',
    ];

    public function catalog()
    {
        return $this->belongsTo(AuctionCatalog::class, 'catalog_id');
    }
}
