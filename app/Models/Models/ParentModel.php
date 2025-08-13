<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    //
     protected $table = 'parents';

    protected $fillable = ['user_id','relation_type'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function children() // users (role=student) عبر pivot
    {
        return $this->belongsToMany(\App\Models\User::class, 'parent_student', 'parent_id', 'student_id')
                    ->withTimestamps();
    }
}
