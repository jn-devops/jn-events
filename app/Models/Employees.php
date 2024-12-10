<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'employee_id',
        'company',
        'last_name',
        'first_name',
        'middle_name',
        'department',
        'floor',
        'unit_group',
        'code',
        'unit',
        'code_1',
    ];
}
