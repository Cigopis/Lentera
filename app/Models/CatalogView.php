<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogView extends Model
{
    protected $fillable = [
        'catalog_id',
        'ip_address',
        'viewed_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function catalog()
    {
        return $this->belongsTo(\App\Models\AuctionCatalog::class, 'catalog_id');
    }
}
