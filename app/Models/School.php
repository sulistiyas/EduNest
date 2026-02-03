<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;
    protected $table = 'schools';
    protected $primaryKey = 'school_id';

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'email',
        'status',
    ];

    // protected $dates = 

    // public function hasManyStudents()
    // {
    //     return $this->hasMany(Student::class, 'school_id', 'school_id');
    // }


}
