<?php

namespace Database\Seeders;

use App\Models\BusinessUnit;
use App\Models\Company;
use App\Models\CompanyLicense;
use App\Models\CompanyLocation;
use Illuminate\Database\Seeder;
use App\Models\EmailNotificationSettings;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data =  Company::create([
            'name' => 'Growth Grid',
            'email' => 'gg@gmail.com',
            'phone_number' => '123456789',
            'website' => 'demo.com'
        ]);

        BusinessUnit::create([
            'name' => 'Growth Grid',
            'address' => 'malvya nagar',
            'pin_code' => '123456',
            'company_id' => $data->id,
            'country_id' => '101',
            'state_id' => '33',
            'city_id' => '3378',
            'phone_number' => '123456789',
            'timezone_id' => '1'
        ]);

        $notificationData = [
            [ 'title' => 'job post notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create company notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create employee notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create candidate notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'profile update notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'Job data notification', 'company_id' => $data->id, 'created_at' => now() ],
        ];

        EmailNotificationSettings::insert($notificationData);

        CompanyLicense::create([
            'license_by' => 'company',
            'license_by_year_from' => date("Y"),
            'license_by_year_to' => date("Y",strtotime("+1 year")),
            'company_id' => $data->id,
        ]);
    }
}
