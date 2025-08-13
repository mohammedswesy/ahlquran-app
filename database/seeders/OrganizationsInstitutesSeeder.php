<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class OrganizationsInstitutesSeeder extends Seeder
{
    public function run(): void
    {
        // 1) هات الأدمن بإيميل السيادر السابق، أو بالدور كبديل
        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@Eyad.com');
$admin = User::where('email', $adminEmail)->first()
      ?? User::role('super-admin')->first();

if (!$admin) {
    throw new \RuntimeException("Admin user with email {$adminEmail} not found.");
}


        // 2) تأكد من وجود دولة ومدينة
        $country = DB::table('countries')->first();
        if (!$country) {
            throw new \RuntimeException('No countries found. Run CountriesCitiesSeeder first.');
        }

        $city = DB::table('cities')->where('country_id', $country->id)->first();
        if (!$city) {
            throw new \RuntimeException('No cities found for the selected country.');
        }

        // 3) أنشئ منظمة
        $orgId = DB::table('organizations')->insertGetId([
            'name'              => 'Ahl Al-Quran Org',
            'supervisor_user_id'=> $admin->id,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // 4) أنشئ معهد
        $instId = DB::table('institutes')->insertGetId([
            'name'            => 'Ahl Al-Quran Institute - Amman',
            'country_id'      => $country->id,
            'city_id'         => $city->id,
            'organization_id' => $orgId,
            'latitude'        => null,
            'longitude'       => null,
            'created_by'      => $admin->id,
            'status'          => 1,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // 5) اربط الأدمن كـ default_admin
        DB::table('institute_admins')->insert([
            'institute_id' => $instId,
            'user_id'      => $admin->id,
            'admin_type'   => 'default_admin',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }
}
