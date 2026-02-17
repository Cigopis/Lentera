<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    protected $table = 'activity_log';

    // Relasi ke Employee (user)
    public function user()
    {
        return $this->belongsTo(Employee::class, 'causer_id');
    }

    // Accessor agar kolom kamu tetap bisa pakai "action"
    public function getActionAttribute()
    {
        return $this->event;
    }

    // Accessor agar bisa pakai "model"
    public function getModelAttribute()
    {
        return class_basename($this->subject_type);
    }
}
