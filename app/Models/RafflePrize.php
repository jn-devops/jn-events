<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RafflePrize extends Model
{
    use HasUuids;

    protected $fillable = ['raffle_id', 'prize_name','image', 'quantity','companies','units'];
    protected $casts = [
        'companies' => 'array',
        'units' => 'array',
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
    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function winners()
    {
        return $this->hasMany(RaffleWinner::class);
    }
}
