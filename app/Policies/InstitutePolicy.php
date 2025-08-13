<?php

namespace App\Policies;

use App\Models\Models\Institute;
use App\Models\User;

class InstitutePolicy
{
    // ✅ helper: سوبر أدمن يمر على كل شيء
    protected function isSuper(User $user): bool
    {
        return method_exists($user, 'hasRole') && $user->hasRole('super-admin');
    }

    // ✅ helper: هل المستخدم أدمن لهذا المعهد؟ (default أو sub)
    protected function isInstituteAdmin(User $user, Institute $institute): bool
    {
        return $institute->admins()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function viewAny(User $user): bool
    {
        return $this->isSuper($user) || $user->hasAnyRole(['institute-admin','employee','teacher','parent','student']);
    }

    public function view(User $user, Institute $institute): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $institute);
    }

    public function create(User $user): bool
    {
        // إنشاء معهد جديد: حصرًا super-admin (عدّل حسب احتياجك)
        return $this->isSuper($user);
    }

    public function update(User $user, Institute $institute): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $institute);
    }

    public function delete(User $user, Institute $institute): bool
    {
        // يفضّل قصر الحذف على super-admin
        return $this->isSuper($user);
    }
}
