<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsModelActivity;

class Category extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
