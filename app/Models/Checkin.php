<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_id_number',
        'name',
    ];

    public function employee()
    {
        return $this->belongsTo(Employees::class, 'employee_id', 'id'); // Define the relationship
    }

}
