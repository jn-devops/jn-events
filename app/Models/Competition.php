<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Competition extends Model
{
    protected $fillable = [
        'name',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Generate UUID if not set
            }
        });
    }
    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'competition_participant');
    }
    public function judges()
    {
        return $this->hasMany(CompetitionJudge::class, 'competition_id');
    }

}
