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

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'school_id', 'school_id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'school_id', 'school_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'school_id', 'school_id');
    }

    public function academicYears()
    {
        return $this->hasMany(Academic_Years::class, 'school_id', 'school_id');
    }

    


}
