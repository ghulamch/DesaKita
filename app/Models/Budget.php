<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'type', 'category', 'amount', 'planned_amount', 'volume', 'satuan', 'output', 'keterangan'];
}
