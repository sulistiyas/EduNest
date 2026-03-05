<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic_Years extends Model
{
    use SoftDeletes;
    protected $table = 'academic_years';
    protected $primaryKey = 'academic_year_id';
    protected $fillable = ['year_name', 'start_date', 'end_date', 'is_active'];

    public function semesters()
    {
        return $this->hasMany(Semester::class, 'academic_year_id', 'academic_year_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'academic_year_id', 'academic_year_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'academic_year_id', 'academic_year_id');
    }


}
