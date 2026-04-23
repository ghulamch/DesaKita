<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apparatus extends Model
{
    use HasFactory;

    protected $table = 'apparatus';

    protected $fillable = ['name', 'role', 'image', 'sort_order', 'parent_id', 'connection_type', 'x', 'y'];

    public function parent()
    {
        return $this->belongsTo(Apparatus::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Apparatus::class, 'parent_id')->orderBy('sort_order');
    }
}
