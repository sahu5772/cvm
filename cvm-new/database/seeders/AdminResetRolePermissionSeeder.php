<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminResetRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($id = 0,$company_id = 0)
    {

        $role =  Role::where('company_id', $company_id)->whereId($id)->first();
        if($role->name === 'admin'){
            $permissions = Permission::whereIn('name', ['employee.add', 'employee.view', 'employee.delete',
            'job post.add', 'job post.view',  'job post.delete'])->get();
        }else{
            $permissions = Permission::whereIn('name', ['employee.add', 'employee.view', 'employee.update',
            'job post.add', 'job post.view', 'job post.update'])->get();
        }

        $role->syncPermissions($permissions);
    }
}
