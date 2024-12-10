<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['title', 'description', 'active'];

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $casts = [
        'active' => 'boolean'
    ];
    public function options()
    {
        return $this->hasMany(PollOptions::class);
    }

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, PollOptions::class);
    }
}
