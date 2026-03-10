<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Class_Subject extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'class_subject_id';
    protected $table = 'class_subjects';
    protected $fillable = [
        'school_id',
        'class_id',
        'subject_id',
        'teacher_id',
        'academic_year_id',
        'created_at',
        'updated_at',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }
    
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_subject_id', 'class_subject_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(Academic_Years::class, 'academic_year_id', 'academic_year_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_subject_id', 'class_subject_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_subject_id', 'class_subject_id');
    }

    


}
