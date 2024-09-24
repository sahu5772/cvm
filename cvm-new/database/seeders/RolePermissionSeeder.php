<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleData = [
            [ 'name' => 'super-admin', 'guard_name' => 'web','company_id' => NULL, 'created_at' => now() ],
            [ 'name' => 'system-admin', 'guard_name' => 'web', 'company_id' => NULL,'created_at' => now() ],
            [ 'name' => 'admin', 'guard_name' => 'web','company_id' => 1, 'created_at' => now() ],
            [ 'name' => 'employee', 'guard_name' => 'web', 'company_id' => 1, 'created_at' => now() ],
        ];

        Role::insert($roleData);

        $permissionData = [
            [ 'name' => 'employee.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job post.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job post.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job post.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job post.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'company.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'company.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'company.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'company.delete', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'educational details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'educational details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'educational details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'educational details.view', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'professional details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'professional details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'professional details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'professional details.view', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'project details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'project details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'project details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'project details.view', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'training details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'training details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'training details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'training details.view', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'membership details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'membership details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'membership details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'membership details.view', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'address details.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'address details.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'address details.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'address details.view', 'guard_name' => 'web', 'created_at' => now() ],


            [ 'name' => 'add keyword.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'cv pdf.download', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'print.print', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'download cv.download', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'location.add', 'guard_name' => 'web', 'created_at' => now() ],

            [ 'name' => 'candidate.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'candidate.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'candidate.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'candidate.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'reports.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'email setting.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'language setting.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'search resumes.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'industries.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'industries.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'industries.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sectors.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sectors.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sectors.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'phase.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'phase.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'phase.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'keyword.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'keyword.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'keyword.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'category.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'category.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'category.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'category.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sub category.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sub category.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sub category.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'sub category.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job type.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job type.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'job type.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'funded agency.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'funded agency.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'funded agency.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'terrains.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'terrains.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'terrains.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'pavement.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'pavement.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'pavement.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education mode.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education mode.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education mode.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'university.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'university.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'university.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'subject.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'subject.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'subject.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'skill.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'skill.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'skill.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education level.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education level.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'education level.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'currency.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'currency.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'currency.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'currency.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'designation.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'designation.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'designation.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'designation.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'department.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'department.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'department.update', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'department.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee type.add', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee type.view', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'employee type.delete', 'guard_name' => 'web', 'created_at' => now() ],
            [ 'name' => 'business_unit.view', 'guard_name' => 'web', 'created_at' => now() ],
        ];

        Permission::insert($permissionData);

        $superAdminRole = Role::findByName('super-admin');

        $superAdminPermissions = Permission::whereIn('name', [
        'employee.add', 'employee.view', 'employee.update','employee.delete',
        'job post.add', 'job post.view', 'job post.update', 'job post.delete',
        'company.add', 'company.view', 'company.update', 'company.delete',
        'candidate.add', 'candidate.view', 'candidate.update', 'candidate.delete',
        'location.add',
        'reports.view','search resumes.view','email setting.view',
        'industries.add', 'industries.view','industries.delete','language setting.view',
        'sectors.add', 'sectors.view', 'sectors.delete',
        'phase.add', 'phase.view','phase.delete',
        'keyword.add', 'keyword.view','keyword.delete',
        'category.add', 'category.view','category.update','category.delete',
        'sub category.add', 'sub category.view', 'sub category.update','sub category.delete',
        'job type.add', 'job type.view','job type.delete',
        'funded agency.add', 'funded agency.view','funded agency.delete',
        'terrains.add', 'terrains.view','terrains.delete',
        'pavement.add', 'pavement.view','pavement.delete',
        'education mode.add', 'education mode.view','education mode.delete',
        'university.add', 'university.view','university.delete',
        'subject.add', 'subject.view','subject.delete',
        'skill.add', 'skill.view','skill.delete',
        'education level.add', 'education level.view','education level.delete',
        'currency.add', 'currency.view', 'currency.update', 'currency.delete',
        'designation.add', 'designation.view', 'designation.update', 'designation.delete',
        'department.add', 'department.view', 'department.update', 'department.delete',
        'employee type.add', 'employee type.view', 'employee type.delete',
        'educational details.add',
        'educational details.update','educational details.delete','educational details.view',
        'professional details.add',
        'professional details.update','professional details.delete','professional details.view',
        'project details.add',
        'project details.update','project details.delete','project details.view',
        'training details.add',
        'training details.update','training details.delete','training details.view',
        'membership details.add',
        'membership details.update','membership details.delete','membership details.view',
        'address details.add',
        'address details.update','address details.delete','address details.view','cv pdf.download','download cv.download','print.print','business_unit.view'
        ])->get();

        $superAdminRole->givePermissionTo($superAdminPermissions);

        $systemAdminPermissions = Permission::whereIn('name', [
        'employee.add', 'employee.view', 'employee.update','employee.delete',
        'job post.add', 'job post.view', 'job post.update', 'job post.delete',
        'candidate.add', 'candidate.view', 'candidate.update', 'candidate.delete',
        'reports.view','search resumes.view','industries.delete','language setting.view',
        'industries.add', 'industries.view','industries.delete',
        'sectors.add', 'sectors.view', 'sectors.delete',
        'phase.add', 'phase.view','phase.delete',
        'keyword.add', 'keyword.view','keyword.delete',
        'category.add', 'category.view','category.delete',
        'sub category.add', 'sub category.view','sub category.delete',
        'job type.add', 'job type.view','job type.delete',
        'funded agency.add', 'funded agency.view','funded agency.delete',
        'terrains.add', 'terrains.view','terrains.delete',
        'pavement.add', 'pavement.view','pavement.delete',
        'education mode.add', 'education mode.view','education mode.delete',
        'university.add', 'university.view','university.delete',
        'subject.add', 'subject.view','subject.delete',
        'skill.add', 'skill.view','skill.delete','email setting.view',
        'education level.add', 'education level.view','education level.delete',
        'currency.add', 'currency.view', 'currency.update', 'currency.delete',
        'designation.add', 'designation.view', 'designation.update', 'designation.delete',
        'department.add', 'department.view', 'department.update', 'department.delete',
        'employee type.add', 'employee type.view', 'employee type.delete',
        'educational details.add','educational details.update','educational details.delete','educational details.view',
        'professional details.add','professional details.update','professional details.delete','professional details.view',
        'project details.add','project details.update','project details.delete','project details.view',
        'training details.add','training details.update','training details.delete','training details.view',
        'membership details.add','membership details.update','membership details.delete','membership details.view',
        'address details.add','address details.update','address details.delete','address details.view','cv pdf.download','cv download.download','print.print'
         ])->get();

        $systemAdminRole = Role::findByName('system-admin');
        $systemAdminRole->givePermissionTo($systemAdminPermissions);

    }
}
