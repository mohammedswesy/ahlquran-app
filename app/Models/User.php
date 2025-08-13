<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,HasApiTokens, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
        'name','email','password','mobile','gender','nationality',
        'birth_date','birth_place','education','id_document','profile_image'
    ];
protected $guard_name = 'web';
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function employee()
    {
        return $this->hasOne(\App\Models\Models\Employee::class);
    }

    // إداري/مشرف لمعهد (عبر جدول institute_admins)
    public function instituteAdmins()
    {
        return $this->hasMany(\App\Models\Models\InstituteAdmin::class);
    }

    // حلقات أُنشئت بواسطة هذا المستخدم (لو بتستخدم created_by)
    public function createdInstitutes()
    {
        return $this->hasMany(\App\Models\Models\Institute::class, 'created_by');
    }

    // إشعارات مستلمة/مرسلة
    public function sentNotifications()
    {
        return $this->hasMany(\App\Models\Models\Notification::class, 'created_by');
    }
    public function receivedNotifications()
    {
        return $this->hasMany(\App\Models\Models\Notification::class, 'recipient_id');
    }
}
