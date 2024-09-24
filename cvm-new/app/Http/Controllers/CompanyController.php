<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Company;
use App\Models\Country;
use App\Models\Language;
use App\Mail\SettingMail;
use App\Models\BusinessUnit;
use App\Models\CompanyLogo;
use App\Models\EmailSetting;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CompanyLicense;
use App\Models\CompanySetting;
use App\Notifications\WelcomeMail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailNotificationSettings;
use App\Models\NotificationRecord;
use App\Models\Timezone;
use Illuminate\Support\Facades\Validator;
use Database\Seeders\AdminResetRolePermissionSeeder;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('company.view')) {

            if ($request->ajax())
            {
                $data = Company::active()->with('getLicense')->where('id', '!=' , '1');

                 return datatables()::of($data)->addIndexColumn()
                            ->addColumn('action', function($row){
                                $actionBtn = '<div class="action--dropdown">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <img src="'. asset('images/icons/more.png').'" alt="" />
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">';
                                $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="unit('.$row->id.')">Business Unit</a>';

                                if (auth()->user()->hasPermissionTo('company.update')) {
                                    $actionBtn .= '<a href="'.route('company.edit', $row->id).'" class="dropdown-item">Edit</a>';
                                }

                                if (auth()->user()->hasPermissionTo('company.delete')) {
                                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteCompany('.$row->id.')">Delete</a>';
                                }

                                $actionBtn .= '</div></div>';
                                return $actionBtn;

                            })
                            ->editColumn('email', function($data) {
                                return strtolower($data->email);
                            })
                            ->filter(function ($query) use ($request) {
                                if (!empty($request->get('is_active'))) {
                                    $query->where('is_active', $request->get('is_active'));
                                }
                                if (!empty($request->get('license_by'))) {
                                    $query->whereHas('getLicense', function ($q) use ($request) {
                                        $q->where('license_by', $request->license_by);
                                    });
                                }
                            })
                            ->rawColumns(['action','email'])
                            ->make(true);
            }

            $countries = Country::get();
            $timezones = Timezone::get();
            return view('company.index',compact('countries', 'timezones'));

        }
        else
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
        if (auth()->user()->hasPermissionTo('company.add')) {
        $country = Country::get();
        $timezones = Timezone::get();
        return view('company.company-add',compact('country', 'timezones'));
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
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required',
            'company_name' => 'required|unique:companies,name',
            'email' => 'required|unique:users,email',
            'company_email' => 'required|unique:companies,email',
            'phone_number' => 'required',
            'pin_code' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'timezone_id' => 'required',
            'website' => 'required',
            'license_by_year_from' => $request->license_by == 'company' ? 'required' :'',
            'license_by_year_to' => $request->license_by == 'company' ? 'required' :'',
            'license_by_user' => $request->license_by == 'user' ? 'required' :'',

        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        $input['name'] = request()->company_name;
        $input['email'] = request()->company_email;
        unset($input['timezone_id']);
        $data = Company::create($input);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $source = time() . rand(11111, 99999) . '.' . $logo->getClientOriginalExtension();
            $destinationPath = public_path('images/company');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $logo->move($destinationPath, $source);
            CompanyLogo::create([
                'logo' => $source,
                'company_id' => $data->id,
            ]);
        }

        CompanySetting::create([
            'company_id' => $data->id,
            'created_by' => Auth::user()->id
        ]);

        BusinessUnit::create([
            'name' => $request->company_name,
            'address' => $request->address,
            'pin_code' => $request->pin_code,
            'timezone_id' => $request->timezone_id,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'phone_number' => $request->phone_number,
            'company_id' => $data->id
        ]);

        CompanyLicense::create([
            'license_by' => $request->license_by,
            'license_by_year_from' => $request->license_by == 'company' && isset($request->license_by_year_from) ? $request->license_by_year_from:' ',
            'license_by_year_to' => $request->license_by == 'company' && isset($request->license_by_year_to)?$request->license_by_year_to:' ',
            'license_by_user' => $request->license_by == 'user' && isset($request->license_by_user)?$request->license_by_user:' ',
            'company_id' => $data->id,
        ]);
        // $password = 'EMP'.rand(1111, 9999);
        $password = '123456789';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'employee_code' => 0,
            'employee_id' => rand(1111, 9999),
            'login_attempt' => '0',
            'company_id' => $data->id,
            'created_by' => Auth::user()->id,
        ]);

        $user->assignRole('system-admin');

        $roleData = [
            [ 'name' => 'admin', 'guard_name' => 'web','company_id' => $data->id, 'created_at' => now() ],
            [ 'name' => 'employee', 'guard_name' => 'web', 'company_id' => $data->id, 'created_at' => now() ],
        ];

        Role::insert($roleData);
        foreach($roleData as $roles){
            $roleData = Role::where('company_id', $data->id)->where('name',$roles['name'])->first();
            $admin = new AdminResetRolePermissionSeeder();
            $admin->run($roleData->id,$data->id);
        }


        $language = [['name' => 'English', 'company_id' => $data->id, 'created_at' => now()], ['name' => 'Hindi', 'company_id' => $data->id, 'created_at' => now()]];

        Language::insert($language);

        $notificationData = [
            [ 'title' => 'job post notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create company notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create employee notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'create candidate notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'profile update notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'candidate data notification', 'company_id' => $data->id, 'created_at' => now() ],
            [ 'title' => 'Job data notification', 'company_id' => $data->id, 'created_at' => now() ],
        ];

        EmailNotificationSettings::insert($notificationData);


        $details = [
            'type' => trans('messages.company.create_company'),
            'data' => 'Username ='.$request->name.'  password ='.$password,
            'notifiable' => $user->email,
            'company_id' => $user->company_id,
            'business_unit_id' => $user->business_unit_id,
        ];

        $email = EmailSetting::where('company_id',Auth::user()->id)->first();
        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title','create company notification')->where('is_active','Active')->exists();
            if($active){
                $data->notify(new WelcomeMail($details));
            }
        }

        NotificationRecord::insert($details);
        return redirect()->route('company.index')->with('success',trans('messages.company.create_company'));

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
        if (auth()->user()->hasPermissionTo('company.update')) {
        $company = Company::where('id',$id)->first();
        $country = Country::get();
        $state = State::get();
        $city = City::get();
        $companyLogo = CompanyLogo::where('company_id',$id)->first();
        $companyLicense = CompanyLicense::where('company_id',$id)->first();
        return view('company.company-edit')->with(['company' => $company,'country' =>$country,'state'=>$state,'city'=>$city,'company_logo'=> $companyLogo,'company_license'=>$companyLicense]);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:companies,name,' . $id,
            'email' => 'required',
            'phone_number' => 'required',
            'website' => 'required',
            'license_by_year_from' => $request->license_by == 'company' ? 'required' :'',
            'license_by_year_to' => $request->license_by == 'company' ? 'required' :'',
            'license_by_user' => $request->license_by == 'user' ? 'required' :'',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        try {
            unset($input['_method']);
            $input['updated_by'] = Auth::user()->id;
            $company = Company::find($id);
            if ($company) {
                CompanyLicense::updateOrCreate(['company_id'=>$company->id],[
                    'license_by' => $request->license_by,
                    'license_by_year_from' => $request->license_by == 'company' && isset($request->license_by_year_from) ? $request->license_by_year_from:' ',
                    'license_by_year_to' => $request->license_by == 'company' && isset($request->license_by_year_to)?$request->license_by_year_to:' ',
                    'license_by_user' => $request->license_by == 'user' && isset($request->license_by_user)?$request->license_by_user:' ',
                    'company_id' => $company->id,
                ]);

                User::updateOrCreate(['company_id'=>$company->id],[
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => '123456',
                    'employee_code' => 0,
                    'employee_id' => rand(1111, 9999),
                    'login_attempt' => '0',
                    'company_id' => $id,
                    'created_by' => Auth::user()->id,
                ]);

                $companyLogo = CompanyLogo::where('company_id', $company->id)->first();
                if(isset($companyLogo)){
                    $imagePath = public_path('company/logo/' . $companyLogo->logo);
                    if (File::exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                if ($request->hasFile('logo')) {
                    $logo = $request->file('logo');
                    $source = time() . rand(11111, 99999) . '.' . $logo->getClientOriginalExtension();
                    $destinationPath = public_path('./images/company');

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }
                    $logo->move($destinationPath, $source);
                    $request['logo'] = $source;

                    CompanyLogo::updateOrCreate(['company_id'=>$company->id],['logo' => $source]);
                }
                $company->update($input);

                return redirect()->route('company.index')->with('success',trans('messages.company.update_company'));
            }

        }catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy(Company $company)
     {
        if (auth()->user()->hasPermissionTo('company.delete')) {
            $company->update(['is_active' => 'Inactive']);
            BusinessUnit::where('company_id', $company->id)->update(['is_active' => 'Inactive']);

            return response()->json([
                'success' => true,
                'message' => trans('messages.company.delete_company'),
            ]);
        }else{
            return redirect()->route('home');
        }

     }

    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
}
