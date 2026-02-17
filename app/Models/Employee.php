<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use App\Traits\LogsModelActivity;
class Employee extends Authenticatable implements FilamentUser
{
    use LogsModelActivity;

    use Notifiable, HasRoles;

    protected $guard_name = 'web';
    protected $table = 'users';


    protected $fillable = [
        'name',
        'username',
        'full_name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->name = $user->full_name;
        });

        static::updating(function ($user) {
            $user->name = $user->full_name;
        });
    }

}
