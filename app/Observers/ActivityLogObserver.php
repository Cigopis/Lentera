<?php

namespace App\Observers;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;

class ActivityLogObserver
{
    protected function log(Model $model, string $action)
    {
        $user = Filament::auth()->user(); // pakai guard Filament

        ActivityLog::create([
            'user_id' => $user?->id, // null jika tidak ada user login
            'action'  => $action,
            'model'   => get_class($model),
        ]);
    }

    public function created(Model $model)
    {
        $this->log($model, 'Created');
    }

    public function updated(Model $model)
    {
        $this->log($model, 'Updated');
    }

    public function deleted(Model $model)
    {
        $this->log($model, 'Deleted');
    }
}
