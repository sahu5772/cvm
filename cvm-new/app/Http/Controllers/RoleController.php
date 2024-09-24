<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\role_has_permissions;
use Database\Seeders\AdminResetRolePermissionSeeder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasAnyRole(['system-admin', 'super-admin'])) {

            $data = Role::where('company_id', Auth::user()->company_id)->get();

            if ($request->ajax()) {

                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editRole(' . $row->id . ')" >Edit</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteRole(' . $row->id . ')" >Delete</a>';

                        if($row->name == 'super-admin' || $row->name == 'system-admin' || $row->name == 'admin' || $row->name == 'employee'){
                            return 'you can not delete this role';
                        }
                        return $btn;
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            $permissions = Permission::get();
            foreach ($permissions as $item) {
                $role_name = explode('.',$item->name);
                $name = $role_name[0];
                if (!isset($permissionData[$name])) {
                    $permissionData[$name] = [];
                }
                // Add the item to the corresponding group
                $permissionData[$name][] = $item;
            }
            if(auth()->user()->company_id !== 1){
                unset($permissionData['company']);
            }

        return view('setting.role-permission', compact('permissionData', 'data'));
    }else
    {
        return redirect()->route('home');
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissionStore(Request $request)
    {
        $role = Role::findOrFail($request->role_id);

       $permissionValue =  DB::table('role_has_permissions')->where('role_id',$request->role_id)->where('permission_id',$request->permission_id)->first();
       if(isset($permissionValue)){
            $role->revokePermissionTo($request->get('permission_id'));
            return response()->json([
                'success' => true,
                'message' => 'permission remove successfully.',
            ]);
        }else{
            $role->givePermissionTo($request->get('permission_id'));
            return response()->json([
                'success' => true,
                'message' => 'permission add successfully.',
            ]);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = Role::where('company_id', Auth::user()->company_id)->count();
        if($roles >=5){
            return response()->json([
                'message' => 'You already added 5 role',
                'status' => false
            ]);
        }
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->get('name'),'company_id' => Auth::user()->company_id]);
        // $role->syncPermissions($request->get('permission'));

        return response()->json([
            'message' => 'Role created successfully',
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions=Permission::all();
        $per_id = $role->permissions->pluck('id');

        $rolePermission = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$role->id)
        ->get();

        return response()->json(['data' => $permissions,'p_id' => $per_id,'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $role->update($request->only('name'));
        $role->syncPermissions($request->get('permission'));

        return response()->json([
            'message' => 'Role update successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Role::where('id',$id)->delete();

        $roles = Role::get();
        $roleData = view('setting.roles-data', compact('roles'))->render();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
            'roles' => $roleData,
        ]);
    }
    public function resetPermission(Request $request)
    {

        $admin = new AdminResetRolePermissionSeeder();
         $admin->run($request->role_id,Auth::user()->company_id);
        return response()->json([
            'success' => true,
            'message' => 'Permission reset successfully.',
        ]);
    }

    public function roleData()
    {
    
        $roles = Role::where('name',auth()->user()->roles->pluck("name"))->orWhere('company_id', Auth::user()->company_id)->get();
        $rolesData = view('setting.roles-data', compact('roles'))->render();
        return response()->json([
            'status' => true,
            'roles' => $rolesData,
        ]);
    }
    public function permissionShow(Request $request)
    {
     $roles = Role::where('id',$request->role_id)->first();
     $permissions = Permission::get();
        foreach ($permissions as $item) {
            $role_name = explode('.',$item->name);
            $name = $role_name[0];
            if (!isset($permissionData[$name])) {
                $permissionData[$name] = [];
            }
            // Add the item to the corresponding group
            $permissionData[$name][] = $item;
        }
        $rolesData = view('setting.roles-tab', compact('roles','permissionData'))->render();
        return response()->json([
            'status' => true,
            'roles_name' => $roles->name,
        ]);
    }
}
