<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteAdmin extends Model
{
    //
     protected $table = 'institute_admins';

    protected $fillable = ['institute_id','user_id','admin_type'];

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
