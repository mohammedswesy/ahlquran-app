<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // دول
        $countryId = DB::table('countries')->insertGetId([
            'name' => 'Jordan',
        ]);

        // مدن
        DB::table('cities')->insert([
            ['name' => 'Amman', 'country_id' => $countryId],
            ['name' => 'Irbid', 'country_id' => $countryId],
        ]);
    }
}
