<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_key',
        'meta_value',
    ];
    
    public static function getVal($key, $default = null)
    {
        $meta = self::where('meta_key', $key)->first();
        return $meta ? $meta->meta_value : $default;
    }

    public static function setVal($key, $value)
    {
        return self::updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }
}
