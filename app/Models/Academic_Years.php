<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic_Years extends Model
{
    use SoftDeletes;
    protected $table = 'academic_years';
    protected $primaryKey = 'academic_year_id';
    protected $fillable = ['school_id', 'year_name', 'start_date', 'end_date', 'is_active'];


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }
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

    public function classSubjects()
    {
        return $this->hasMany(Class_Subject::class, 'academic_year_id', 'academic_year_id');
    }


}
