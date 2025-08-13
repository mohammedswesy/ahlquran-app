<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = ['title','message','created_by','recipient_id'];

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function recipient()
    {
        return $this->belongsTo(\App\Models\User::class, 'recipient_id');
    }
}
