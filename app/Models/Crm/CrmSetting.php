<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CrmSetting extends Model
{
    protected $table = 'crm_settings';
    protected $guarded = [];

    public static function get($key, $default = null)
    {
        $setting = self::where('key_name', $key)->first();
        return $setting ? $setting->value_data : $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['key_name' => $key], ['value_data' => $value]);
    }
}
