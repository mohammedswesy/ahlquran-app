<?php

namespace App\Policies;

use App\Models\Models\Circle;
use App\Models\Models\Institute;
use App\Models\User;

class CirclePolicy
{
    protected function isSuper(User $user): bool
    {
        return method_exists($user, 'hasRole') && $user->hasRole('super-admin');
    }

    protected function isInstituteAdmin(User $user, Institute $institute): bool
    {
        return $institute->admins()->where('user_id', $user->id)->exists();
    }

    public function viewAny(User $user): bool
    {
        return $this->isSuper($user) || $user->hasAnyRole(['institute-admin','teacher','employee','student','parent']);
    }

    public function view(User $user, Circle $circle): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $circle->institute);
    }

    public function create(User $user, Institute $institute): bool
    {
        // إنشاء حلقة في معهد: أدمن المعهد أو super
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $institute);
    }

    public function update(User $user, Circle $circle): bool
    {
        // أدمن المعهد أو منشئ الحلقة أو super
        return $this->isSuper($user)
            || $this->isInstituteAdmin($user, $circle->institute)
            || $circle->created_by === $user->id;
    }

    public function delete(User $user, Circle $circle): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $circle->institute);
    }
}
