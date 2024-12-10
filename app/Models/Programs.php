<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Programs extends Model
{
    protected $fillable = [
        'link',
        'name',
        'active'
    ];
    protected $casts = [
        'active'=>'boolean',
    ];
}
