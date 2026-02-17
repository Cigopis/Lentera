<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Events\ModelCreated;
use Illuminate\Database\Events\ModelUpdated;
use Illuminate\Database\Events\ModelDeleted;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\City;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::share('categories', Category::where('is_active', true)->get());
        View::share('cities', City::where('is_active', true)->get());

        Event::listen(ModelCreated::class, function ($event) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action'  => 'Created',
                'model'   => get_class($event->model),
            ]);
        });

        Event::listen(ModelUpdated::class, function ($event) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action'  => 'Updated',
                'model'   => get_class($event->model),
            ]);
        });

        Event::listen(ModelDeleted::class, function ($event) {
            $user = Filament::auth()->user();
            ActivityLog::create([
                'user_id' => $user?->id,
                'action'  => 'Deleted',
                'model'   => get_class($event->model),
            ]);
        });
    }
}
