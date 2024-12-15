<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'category',
        'image',
        'song'
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
