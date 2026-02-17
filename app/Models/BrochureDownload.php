<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrochureDownload extends Model
{
    protected $fillable = [
        'catalog_id',
        'ip_address',
        'downloaded_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function catalog()
    {
        return $this->belongsTo(\App\Models\AuctionCatalog::class, 'catalog_id');
    }
}
