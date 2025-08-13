<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = ['user_id','circle_id','start_time','end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }
}
