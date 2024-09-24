<?php
namespace Database\Seeders;
use App\Models\JobCategory;
use App\Models\JobSubCategory;
use App\Models\JobType;
use App\Models\User;
use App\Models\Phase;
use App\Models\Sector;
use App\Models\Subject;
use App\Models\Industry;
use App\Models\Language;
use App\Models\Terrains;
use App\Models\Department;
use App\Models\Membership;
use App\Models\University;
use App\Models\Certificate;
use App\Models\CompanyPerk;
use App\Models\Designation;
use App\Models\ContractMode;
use App\Models\EducationMode;
use App\Models\FundingAgency;
use App\Models\CompanySetting;
use Illuminate\Database\Seeder;
use App\Models\EducationalLevel;
use App\Models\Skill;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'super admin',
            'email' => 'super@gmail.com',
            'password' => '123456',
            'employee_id' => '1',
            'company_id' => '1',
            'created_by' => '1',
        ]);
        $user->assignRole('super-admin');

        $data = [['created_by' => '1', 'company_id' => '1', 'created_at' => now()]];

        CompanySetting::insert($data);

        $designation = [
            ['name' => 'Director General', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Account Receivable Associate', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accountant', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accounts & Administration Officer	', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accounts Assistant', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accounts Executive', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accounts Manager', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Accounts Officer', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Act. Team Leader / Resident Engineer', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Acting Team leader', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Additional Chief Engineer', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Additional Chief Project Manager', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
            ['name' => 'Additional Director General', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1],
        ];

        Designation::insert($designation);

        $department = [['name' => 'HR', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1], ['name' => 'IT', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1], ['name' => 'Accounts', 'company_id' => '1', 'created_at' => now(), 'created_by' => 1]];

        Department::insert($department);

        $language = [['name' => 'English', 'company_id' => '1', 'created_at' => now()], ['name' => 'Hindi', 'company_id' => '1', 'created_at' => now()]];

        Language::insert($language);

        $eduMode = [['name' => 'Distance', 'company_id' => '1', 'created_at' => now()], ['name' => 'Regular', 'company_id' => '1', 'created_at' => now()], ['name' => 'Part Time', 'company_id' => '1', 'created_at' => now()]];

        EducationMode::insert($eduMode);

        $ind = [['name' => 'civil', 'company_id' => '1', 'created_at' => now()], ['name' => 'Metro', 'company_id' => '1', 'created_at' => now()]];

        Industry::insert($ind);

        $sector = [
            ['name' => 'Aviation', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Bridge', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Environment', 'company_id' => '1', 'industry_id' => '2', 'created_at' => now()],
            ['name' => 'Building', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Food', 'company_id' => '1', 'industry_id' => '2', 'created_at' => now()],
            ['name' => 'Geotechnical', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Highway', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Metro', 'company_id' => '1', 'industry_id' => '2', 'created_at' => now()],
            ['name' => 'Other Sector', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Pharma', 'company_id' => '1', 'industry_id' => '2', 'created_at' => now()],
            ['name' => 'Railway', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Road', 'company_id' => '1', 'industry_id' => '1', 'created_at' => now()],
            ['name' => 'Water', 'company_id' => '1', 'industry_id' => '2', 'created_at' => now()],
        ];

        Sector::insert($sector);

        $edu = [['name' => '10th', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()], ['name' => '12th	', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()], ['name' => 'Certification Courses', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()], ['name' => 'Diploma', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()], ['name' => 'Graduation', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()], ['name' => 'PG Diploma', 'company_id' => '1', 'created_by' => '1', 'created_at' => now()]];

        EducationalLevel::insert($edu);
        $cer = [['name' => 'Auto CAD', 'company_id' => '1', 'created_at' => now()], ['name' => 'Civil 2D / 3D', 'company_id' => '1', 'created_at' => now()], ['name' => 'Computer Applications', 'company_id' => '1', 'created_at' => now()], ['name' => 'Project Management	', 'company_id' => '1', 'created_at' => now()], ['name' => 'Road Safety', 'company_id' => '1', 'created_at' => now()], ['name' => 'Safety Diploma', 'company_id' => '1', 'created_at' => now()]];

        Certificate::insert($cer);

        $membership = [['name' => 'Associate Member of the Institute of Civil Engineers (AMICE)', 'company_id' => '1', 'created_at' => now()], ['name' => 'Indian Buildings Congress (IBC)', 'company_id' => '1', 'created_at' => now()], ['name' => 'Indian Roads Congress (IRC)', 'company_id' => '1', 'created_at' => now()], ['name' => 'Institution of Mechanical Engineers (IME)', 'company_id' => '1', 'created_at' => now()], ['name' => 'Institution of Structural Engineers (ISE)', 'company_id' => '1', 'created_at' => now()], ['name' => 'Others (Manual Entry)', 'company_id' => '1', 'created_at' => now()], ['name' => 'The Institution of Engineering & Technology (IET)', 'company_id' => '1', 'created_at' => now()], ['name' => 'The Institution of Engineers India (IEI)', 'company_id' => '1', 'created_at' => now()]];

        Membership::insert($membership);

        $ind = [['name' => 'commerce', 'company_id' => '1', 'created_at' => now()], ['name' => 'science', 'company_id' => '1', 'created_at' => now()], ['name' => 'maths', 'company_id' => '1', 'created_at' => now()]];

        Industry::insert($ind);

        $mode = [['name' => 'EPC', 'company_id' => '1', 'created_at' => now()], ['name' => 'HAM', 'company_id' => '1', 'created_at' => now()], ['name' => 'PPC', 'company_id' => '1', 'created_at' => now()], ['name' => 'OTHER', 'company_id' => '1', 'created_at' => now()]];

        ContractMode::insert($mode);

        $agency = [['name' => 'funding agency1', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding agency2', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding agency3', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding agency4', 'company_id' => '1', 'created_at' => now()]];

        FundingAgency::insert($agency);

        $terr = [['name' => 'funding terrains 1', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding terrains 2', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding terrains 3', 'company_id' => '1', 'created_at' => now()], ['name' => 'funding terrains 4', 'company_id' => '1', 'created_at' => now()]];

        Terrains::insert($terr);

        $phase = [['name' => 'phase 1', 'industry_id' => '1', 'sector_id' => '1', 'company_id' => '1', 'created_at' => now()], ['name' => 'phase 2', 'industry_id' => '1', 'sector_id' => '1', 'company_id' => '1', 'created_at' => now()], ['name' => 'phase 3', 'industry_id' => '1', 'sector_id' => '1', 'company_id' => '1', 'created_at' => now()], ['name' => 'phase 4', 'industry_id' => '1', 'sector_id' => '1', 'company_id' => '1', 'created_at' => now()]];

        Phase::insert($phase);

        $sub = [['name' => 'computer', 'company_id' => '1', 'created_at' => now()], ['name' => 'hindi', 'company_id' => '1', 'created_at' => now()], ['name' => 'maths', 'company_id' => '1', 'created_at' => now()]];

        Subject::insert($sub);
        $uni = [
            [
                'name' => 'University of Rajasthan',
                'company_id' => '1',
                'country_id' => '101',
                'state_id' => '33',
                'city_id' => '3378',
                'created_at' => now(),
            ],
            [
                'name' => 'University of Punjab',
                'company_id' => '1',
                'country_id' => '101',
                'state_id' => '32',
                'city_id' => '594',
                'created_at' => now(),
            ],
        ];


        University::insert($uni);

        $cat = [
            ['name' => 'Software Development', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
             ['name' => 'Network Administration', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
             ['name' => 'Cybersecurity', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
             ['name' => 'Database Administration', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
             ['name' => 'Web Development', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
        ];

        JobCategory::insert($cat);

        $subcat = [
            ['name' => 'Front-End Development', 'company_id' => '1', 'job_category_id' =>1, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Back-End Development', 'company_id' => '1', 'job_category_id' =>1, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Network Security', 'company_id' => '1', 'job_category_id' =>2, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Cloud Networking', 'company_id' => '1', 'job_category_id' =>2, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Information Security', 'company_id' => '1', 'job_category_id' =>3, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Ethical Hacking', 'company_id' => '1', 'job_category_id' =>3, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Database Design', 'company_id' => '1', 'job_category_id' =>4, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Database Optimization', 'company_id' => '1', 'job_category_id' =>4, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Full-Stack Development', 'company_id' => '1', 'job_category_id' =>5, 'created_at' => now() ,'created_by' => '1',],
            ['name' => 'Web Application Frameworks', 'company_id' => '1', 'job_category_id' =>5, 'created_at' => now() ,'created_by' => '1',],
        ];

        JobSubCategory::insert($subcat);

        $skill = [
            ['name' => 'HTML', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',], 
            ['name' => 'CSS', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'php', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Ajax', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Node js', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
        ];

        Skill::insert($skill);

        $jobtype = [
            ['name' => 'Full-Time Job', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',], 
            ['name' => 'Part-Time Job', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Remote Job', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Freelance Job', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Internship', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
        ];

        JobType::insert($jobtype);

        $perks = [
            ['name' => 'Paid Time Off (PTO)', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',], 
            ['name' => 'Healthcare Benefits', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Paid Volunteer Time', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Employee Assistance Programs (EAPs)', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
            ['name' => 'Life Insurance', 'company_id' => '1', 'created_at' => now(), 'created_by' => '1',],
        ];

        CompanyPerk::insert($perks);
    }
}
