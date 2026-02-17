<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsModelActivity;

class City extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'name',
        'province',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function auctionCatalogs()
    {
        return $this->hasMany(AuctionCatalog::class);
    }
}
