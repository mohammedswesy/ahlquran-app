<?php

namespace App\Policies;

use App\Models\Models\Employee;
use App\Models\Models\Institute;
use App\Models\User;

class EmployeePolicy
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
        return $this->isSuper($user) || $user->hasAnyRole(['institute-admin','employee']);
    }

    public function view(User $user, Employee $employee): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $employee->institute);
    }

    public function create(User $user, Institute $institute): bool
    {
        // إنشاء موظف داخل معهد معيّن: أدمن هذا المعهد أو super
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $institute);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $employee->institute);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $this->isSuper($user) || $this->isInstituteAdmin($user, $employee->institute);
    }
}
