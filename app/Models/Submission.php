<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'submission_id';
    protected $table = 'submissions';
    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
    ];
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'submission_id', 'submission_id');
    }

    
}
