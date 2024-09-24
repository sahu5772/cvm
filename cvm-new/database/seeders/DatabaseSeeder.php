<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CandidateProject;
use Illuminate\Support\Facades\DB;
use App\Models\CandidateEducationalDetail;
use App\Models\Candidate;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $sql_country = base_path('database/seeders/countries.sql');
        DB::unprepared(file_get_contents($sql_country));
        $state_sql = base_path('database/seeders/states.sql');
        DB::unprepared(file_get_contents($state_sql));
        $city_sql = base_path('database/seeders/cities.sql');
        DB::unprepared(file_get_contents($city_sql));
        $sql_timezone = base_path('database/seeders/time_zone.sql');
        DB::unprepared(file_get_contents($sql_timezone));
        $this->call(CurrencySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        Candidate::factory(100)->create();
        // CandidateEducationalDetail::factory(100)->create();
        // CandidateProject::factory(100)->create();
    }
}
