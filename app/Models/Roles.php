<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}
