<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['id','poll_id','poll_option_id', 'employee_id'];

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
                $model->id = (string) Str::uuid(); // Generate UUID if not set
        });
    }
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
    public function pollOption()
    {
        return $this->belongsTo(PollOptions::class, 'poll_option_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'id'); // Define the relationship
    }
}
