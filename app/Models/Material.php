<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'material_id';
    protected $table = 'materials';
    protected $fillable = [
        'class_subject_id',
        'title',
        'description',
        'file_path',
    ];

    public function classSubject()
    {
        return $this->belongsTo(Class_Subject::class, 'class_subject_id', 'class_subject_id');
    }

    
}
