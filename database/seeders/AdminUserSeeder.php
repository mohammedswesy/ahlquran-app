<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.ACAA
     */
    public function run(): void
    {
        //
             $email = env('SEED_ADMIN_EMAIL', 'admin@Eyad.com'); // قراءة الإيميل من env

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('123456789'),
                'mobile' => '0000000000',
                'gender' => 'male',
                'nationality' => 'JO',
            ]
        );

        // role
        $user->assignRole('super-admin');
    }
    }

