<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\BusinessUnit;
use App\Models\EmailSetting;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Notifications\ProfileUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EmailNotificationSettings;
use App\Models\NotificationRecord;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CreateEmployeeEmail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('employee.view')) {
            if ($request->ajax()) {
                    $data = User::active()->company()->where('id', '!=', Auth::user()->id)->whereHas('roles', function ($query) {
                        $query->where('roles.name', '!=', 'super-admin');
                    })->with('roles');
                    return Datatables::of($data)
                        ->addColumn('action', function($row){
                            $role = $row->getRoleNames()->first();
                            $actionBtn = '';
                            if($role !== 'system-admin'){
                                $actionBtn = '<div class="action--dropdown">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <img src="'. asset('images/icons/more.png').'" alt="" />
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">';
                                if (!auth()->user()->hasPermissionTo('employee.update') && !auth()->user()->hasPermissionTo('employee.delete')) {
                                    $actionBtn = '';
                                    $actionBtn .= 'No Access';
                                }else{

                                    if (auth()->user()->hasPermissionTo('employee.update')) {
                                        $actionBtn .= '<a href="' . route('users.edit', $row->id) .'" class="dropdown-item" data-id="'.$row->id.'">Edit</a>';
                                    }
                                    if (auth()->user()->hasPermissionTo('employee.delete')) {
                                        $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" data-id="'.$row->id.'" >Delete</a>';
                                    }
                                    $actionBtn .= '</div></div>';
                                }
                            }else{
                                $actionBtn = '';
                                $actionBtn .="You don't have access to update and delete";
                            }
                            return $actionBtn;
                        })
                        ->addColumn('checkbox', function($row){
                            return '<input type="checkbox" id="'.$row->id.'" />';
                        })
                        ->filter(function ($query) use ($request) {
                            if (!empty($request->get('gender'))) {
                                $query->where('gender', $request->get('gender'));
                            }
                            if (!empty($request->get('department_id'))) {
                                $query->where('department_id', $request->get('department_id'));
                            }
                            if (!empty($request->get('is_active'))) {
                                $query->where('is_active', $request->get('is_active'));
                            }
                            if (!empty($request->get('role_id'))) {
                                $query->whereHas('roles', function ($q) use ($request) {
                                    $q->where('id', $request->role_id);
                                });
                            }
                        })
                        ->editColumn('employee_id', function($data) {
                            $prefix = CompanySetting::where('company_id', Auth::user()->company_id)->first();
                            return ($data) ? ucfirst($prefix->prefix . $prefix->separator . $data->employee_id) : '--';
                        })
                        ->editColumn('role', function($data) {
                            $role = $data->getRoleNames()->first();
                            return ($role) ? ucfirst($role) : '--';
                        })
                        ->rawColumns(['action', 'checkbox'])
                        ->make(true);
                }
                $departments = Department::where('company_id', Auth::user()->company_id)->active()->get();
                $roles = Role::where('company_id', Auth::user()->company_id)->get();
                return view('users.index',compact('roles', 'departments'));
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
    public function create()
    {
        if (auth()->user()->hasPermissionTo('employee.add')) {
            $roles = Role::where('company_id', Auth::user()->company_id)->get();
            $departments = Department::where('company_id', Auth::user()->company_id)->active()->get();
            $designations = Designation::where('company_id', Auth::user()->company_id)->active()->get();
            $users = User::where('company_id', Auth::user()->company_id)->get();
            $units = BusinessUnit::where('company_id', Auth::user()->company_id)->get();
            return view('users.create', compact('roles', 'departments', 'designations', 'users','units'));
        }else{
            return redirect()->route('home');
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
        $request->validate([
            'employee_id' => 'required|numeric|unique:users,employee_id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,NULL,id,company_id,' .auth()->user()->company_id,
            'designation' => 'required',
            'department' => 'required',
            'business_unit' => 'required',
            'role' => 'required',
            'joining_date' => 'required|date|before:today',
            'dob' => 'required|date|before:18 years ago',
            'user' => 'required',
        ]);

        $password = '123456789'; //at the time of notification replace static password with random number

        $data = [
            'employee_id'    => request()->employee_id,
            'name'           => request()->name,
            'email'          => request()->email,
            'password'       => $password,
            'created_by'     => Auth::user()->id,
            'company_id'     => Auth::user()->company_id,
            'designation_id' => request()->designation,
            'department_id'  => request()->department,
            'joining_date'   => request()->joining_date,
            'dob'            => request()->dob,
            'login_attempt'  => '3',
            'reporting_to'   => request()->user,
            'gender'         => request()->gender,
            'business_unit_id' => request()->business_unit,
        ];

        if ($request->hasFile('employee_image')) {
            $profileImage = $request->file('employee_image');
            $source = time() . rand(11111, 99999) . '.' . $profileImage->getClientOriginalExtension();
            $destinationPath = public_path('images/employee');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $profileImage->move($destinationPath, $source);
            $data['profile_picture'] = $source;
        }

        User::create($data);

        $user = User::where('email', request()->email)->first();

        $role = Role::where('id',request()->role)->where('company_id',auth()->user()->company_id)->first();
        if($role){
            $role->users()->attach($user);
        }else{
            $role = Role::where('id',request()->role)->first();
            $role->users()->attach($user);
        }

        $details = [
            'type' => trans('messages.company.create_company'),
            'data' => 'Username ='.$request->name.'  password ='.$password,
            'notifiable' => $user->email,
            'company_id' => $user->company_id,
            'business_unit_id' => $user->business_unit_id,
        ];

        $email = EmailSetting::where('company_id',Auth::user()->id)->first();
        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title','create employee notification')->where('is_active','Active')->exists();
            if($active){
                $user->notify(new CreateEmployeeEmail($details));
            }
            NotificationRecord::insert($details);
        }

        return redirect()->route('users.index')->with('success',trans('messages.employee.create_employee'));
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
    public function edit($id)
    {
        if (auth()->user()->hasPermissionTo('employee.update')) {
            $user = User::where('company_id', Auth::user()->company_id)->find($id);
            $roles = Role::where('company_id', Auth::user()->company_id)->get('name');
            $currentRole = $user->getRoleNames()->first();
            $departments = Department::get();
            $designations = Designation::get();
            $units = BusinessUnit::where('company_id', Auth::user()->company_id)->get();
            $reporting = User::where('company_id', Auth::user()->company_id)->get();
            return view('users.edit', compact('units','user', 'roles', 'currentRole', 'departments', 'designations', 'reporting'));
        }else{
            return redirect()->route('home');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $this->validate($request, [
            'employee_id' => 'required|numeric|unique:users,employee_id,'.$id,
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->where('company_id', auth()->user()->company_id);
                })->ignore($id),
            ],
            'designation' => 'required',
            'department' => 'required',
            'role' => 'required',
            'business_unit' => 'required',
            'joining_date' => 'required|date|before:today',
            'dob' => 'required|date|before:18 years ago',
            'user' => 'required',
        ]);

        $image = User::where('id', $id)->first();

        if(!empty($image->profile_picture)){
            $imagePath = public_path('images/employee/' . $image->profile_picture);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $image = '';

        if ($request->hasFile('employee_image')) {
            $image = $request->file('employee_image');
            $source = time() . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('./images/employee');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $image->move($destinationPath, $source);
            $image = $source;

        }

        User::whereId($id)->update([
            'employee_id'    => request()->employee_id,
            'name'           => request()->name,
            'email'          => request()->email,
            'updated_by'     => Auth::user()->id,
            'company_id'     => Auth::user()->company_id,
            'designation_id' => request()->designation,
            'department_id'  => request()->department,
            'joining_date'   => request()->joining_date,
            'dob'            => request()->dob,
            'reporting_to'   => request()->user,
            'gender'         => request()->gender,
            'business_unit_id' => request()->business_unit,
            'profile_picture'=> $image,
        ]);
        if(request()->password !== Null){
            User::whereId($id)->update([
                'password'       => Hash::make(request()->password),
            ]);
        }

        $user = User::where('email', request()->email)->where('company_id',auth()->user()->company_id)->first();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $role = Role::where('name',request()->role)->where('company_id',auth()->user()->company_id)->first();

        $user->roles()->attach($role->id);

        return redirect()->route('users.index')->with('success',trans('messages.employee.update_employee'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('employee.delete')) {
            $data = User::whereId($id)->update(['is_active' => 'Inactive']);

            return response()->json([
                'success' => true,
                'message' => trans('messages.employee.delete_employee'),
            ]);
        }else{
            return redirect()->route('home');
        }

    }

    public function profileSettings(Request $request)
{
    if ($request->isMethod('post')) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    $query->where('company_id', auth()->user()->company_id);
                })->ignore($request->id),
            ],
            'dob' => 'required|date|before:18 years ago',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::where('id', $request->id)->first();
        if($image = $user->profile_picture){
            $image = $user->profile_picture;
        }else{
            $image = 'userr.png';
        }
        if(!empty($request->hasFile('profile_picture'))){
            $image = $user->profile_picture;
            if(!empty($image)){
                $imagePath = public_path('images/employee/' . $image);
                if (File::exists($imagePath)) {
                    unlink($imagePath);
                }
            }


        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $source = time() . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('./images/employee');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $image->move($destinationPath, $source);
            $image = $source;

            User::whereId($request->id)->update([
                'profile_picture'=> $image,
            ]);
        }
    }
        User::whereId($request->id)->update([
            'name'           => request()->name,
            'email'          => request()->email,
            'email_notification'=> request()->email_notification,
            'updated_by'     => Auth::user()->id,
            'company_id'     => Auth::user()->company_id,
            'dob'            => request()->dob,
            'gender'         => request()->gender,
        ]);
        if(request()->password !== Null){
            User::whereId($request->id)->update([
                'password'       => Hash::make(request()->password),
            ]);
        }

        $details = [
            'type' => trans('messages.company.update'),
            'data' => 'your profile updated',
            'notifiable' => $user->email,
            'company_id' => $user->company_id,
            'business_unit_id' => $user->business_unit_id,
        ];

        $email = EmailSetting::where('company_id',Auth::user()->id)->first();
        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title','profile update notification')->where('is_active','Active')->exists();
            if($active){
                $user->notify(new ProfileUpdate($details));
            }
            NotificationRecord::insert($details);
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'logo' => url('/images/employee/'.$image),
        ]);
    } elseif ($request->isMethod('get')) {
        $user = auth()->user();
        return view('users.profile-edit', compact('user'));
    }
}
}
