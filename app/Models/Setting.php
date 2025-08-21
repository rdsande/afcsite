<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Get jersey image URL
     */
    public static function getJerseyImage()
    {
        $jerseyImage = static::get('jersey_image');
        if ($jerseyImage && Storage::disk('public')->exists($jerseyImage)) {
            return Storage::url($jerseyImage);
        }
        return asset('images/jezi.png'); // fallback to default
    }
}
