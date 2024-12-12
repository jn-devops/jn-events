<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'competition_id',
        'participant_id',
        'judge_id',
        'criteria',
        'score'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
