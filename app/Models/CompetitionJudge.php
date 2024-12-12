<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionJudge extends Model
{
    protected $fillable = [
        'name',
        'competition_id',
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
