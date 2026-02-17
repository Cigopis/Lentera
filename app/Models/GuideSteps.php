<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsModelActivity;

class GuideSteps extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'step_number',
        'title',
        'description',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
