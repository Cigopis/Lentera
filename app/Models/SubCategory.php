<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsModelActivity;

class SubCategory extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
