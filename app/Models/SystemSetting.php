<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\LogsModelActivity;

class SystemSetting extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'updated_by',
    ];


    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public static function getValue(string $key, $default = null)
    {
        return static::where('setting_key', $key)->value('setting_value') ?? $default;
    }
}
