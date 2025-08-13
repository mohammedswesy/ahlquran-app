<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Institute extends Model
{
    //
     use SoftDeletes;

    protected $fillable = [
        'name','country_id','city_id','organization_id',
        'latitude','longitude','created_by','status'
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function admins()
    {
        return $this->hasMany(InstituteAdmin::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }
}
