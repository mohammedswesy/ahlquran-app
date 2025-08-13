<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    //
    protected $table = 'parent_student';
    protected $fillable = ['parent_id','student_id'];
}
