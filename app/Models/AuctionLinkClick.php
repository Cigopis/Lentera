<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionLinkClick extends Model
{
    protected $fillable = [
        'catalog_id',
        'ip_address',
        'clicked_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function catalog()
    {
        return $this->belongsTo(\App\Models\AuctionCatalog::class, 'catalog_id');
    }
}
