<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'class_id';
    protected $fillable = [
        'name',
        'school_id',
        'class_name',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id', 'class_id');
    }
}
