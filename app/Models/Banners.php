<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsModelActivity;

class Banners extends Model
{
    use LogsModelActivity;
    protected $fillable = [
        'title',
        'image_path',
        'link_url',
        'catalog_id',
        'created_by',
        'is_active',
    ];

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(AuctionCatalog::class, 'catalog_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
