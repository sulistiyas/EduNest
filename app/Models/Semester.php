<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use SoftDeletes;
    protected $table = 'semesters';
    protected $primaryKey = 'semester_id';
    protected $fillable = ['academic_year_id', 'semester_name', 'start_date', 'end_date', 'is_active'];

    public function academicYear()
    {
        return $this->belongsTo(Academic_Years::class, 'academic_year_id', 'academic_year_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'semester_id', 'semester_id');
    }

    
}
