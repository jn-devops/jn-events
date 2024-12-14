<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RaffleWinner extends Model
{
    use  HasUuids;

    protected $fillable = ['raffle_id', 'raffle_prize_id','employee_id'];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function prize()
    {
        return $this->belongsTo(RafflePrize::class, 'raffle_prize_id');
    }


    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'id'); // Define the relationship
    }
}
