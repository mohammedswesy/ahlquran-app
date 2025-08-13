<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    //
    protected $fillable = [
        'name','institute_id','type','start_time','end_time','created_by'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
