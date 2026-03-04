<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brochure extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_catalog_id',
        'snapshot_data',
        'file_path',
    ];

    protected $casts = [
        'snapshot_data' => 'array',
    ];

    public function catalog()
    {
        return $this->belongsTo(AuctionCatalog::class, 'auction_catalog_id');
    }
}
