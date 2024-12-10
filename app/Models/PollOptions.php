<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOptions extends Model
{
    protected $fillable = ['poll_id', 'option'];

    public $incrementing = false;
    protected $keyType = 'uuid';

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
