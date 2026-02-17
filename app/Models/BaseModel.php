<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;
use App\Models\ActivityLog;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::created(function ($model) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'Created',
                'model' => get_class($model),
            ]);
        });

        static::updated(function ($model) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'Updated',
                'model' => get_class($model),
            ]);
        });

        static::deleted(function ($model) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'Deleted',
                'model' => get_class($model),
            ]);
        });
    }
}
