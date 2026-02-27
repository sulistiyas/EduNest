<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'assignment_id';
    protected $table = 'assignments';
    protected $fillable = [
        'class_subject_id',
        'title',
        'description',
        'due_date',
    ];

    public function classSubject()
    {
        return $this->belongsTo(Class_Subject::class, 'class_subject_id', 'class_subject_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assignment_id', 'assignment_id');
    }

    
}
