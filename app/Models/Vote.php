<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['poll_option_id', 'employee_id'];

    public $incrementing = false;
    protected $keyType = 'uuid';

    public function pollOption()
    {
        return $this->belongsTo(PollOptions::class);
    }
}
