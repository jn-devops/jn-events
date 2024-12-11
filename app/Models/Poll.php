<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Poll extends Model
{
    protected $fillable = ['title', 'description', 'active'];

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $casts = [
        'active' => 'boolean'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID if not set
            }
        });
    }
    public function options()
    {
        return $this->hasMany(PollOptions::class);
    }

    public function votes()
    {
        return $this->hasManyThrough(Vote::class, PollOptions::class, 'poll_id', 'poll_option_id', 'id', 'id');
    }
}
