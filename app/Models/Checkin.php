<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
      'employee_id',
      'name',
    ];

}
