<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'class_subject_id',
        'semester_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
    ];

    public function classSubject()
    {
        return $this->belongsTo(Class_Subject::class, 'class_subject_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
