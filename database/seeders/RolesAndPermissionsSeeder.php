<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //تنظيف سابق
          app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            // Institutes
            'institutes.view', 'institutes.create', 'institutes.update', 'institutes.delete',
            // Employees
            'employees.view', 'employees.create', 'employees.update', 'employees.delete',
            // Circles
            'circles.view', 'circles.create', 'circles.update', 'circles.delete',
            // Attendance
            'attendance.view', 'attendance.create', 'attendance.update', 'attendance.delete',
            // Notifications
            'notifications.send', 'notifications.view',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);
        }

        $roles = [
            'super-admin'      => $permissions, // كل شيء
            'institute-admin'  => [
                'institutes.view','institutes.update',
                'employees.view','employees.create','employees.update',
                'circles.view','circles.create','circles.update',
                'attendance.view','attendance.create',
                'notifications.send','notifications.view',
            ],
            'employee'         => ['employees.view','attendance.view','notifications.view'],
            'teacher'          => ['circles.view','attendance.create','notifications.view'],
            'student'          => ['circles.view','notifications.view'],
            'parent'           => ['notifications.view'],
        ];

        foreach ($roles as $role => $allowed) {
            $r = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            $r->syncPermissions($allowed);
        }
    
    }
}
