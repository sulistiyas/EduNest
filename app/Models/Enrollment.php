<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'enrollment_id';
    protected $table = 'enrollments';

    protected $fillable = [
        'student_id',
        'class_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(Academic_Years::class, 'academic_year_id', 'academic_year_id');
    }

    


}
