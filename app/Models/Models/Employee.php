<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
     use SoftDeletes;

    protected $fillable = [
        'user_id','institute_id','job_title','cv_file','marital_status',
        'qualifications','nationality','address','id_document'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
