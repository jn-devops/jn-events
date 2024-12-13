<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Prizes extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'description',
        'image',
        'companies',
    ];

    protected $casts = [
        'companies' => 'array',
    ];

    protected $appends = [
        'employees',
        'employee_names',
    ];

    public function getEmployeesAttribute(){
        return Employees::whereIn('company', $this->companies)->get();
    }
    
    public function getEmployeeNamesAttribute(){
        return Employees::whereIn('company', $this->companies)->get()->pluck('name')->toArray();
    }
}
