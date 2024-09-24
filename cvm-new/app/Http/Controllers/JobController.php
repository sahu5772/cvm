<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\City;
use App\Models\User;
use App\Models\Skill;
use App\Models\State;
use App\Models\Company;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\JobSkill;
use App\Helpers\JobHelper;
use App\Models\BusinessUnit;
use App\Models\Department;
use App\Models\CompanyLogo;
use App\Models\CompanyPerk;
use App\Models\JobCategory;
use App\Models\EmailSetting;
use App\Models\JobEducation;
// use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CompanyLicense;
use App\Models\JobCompanyPerk;
use App\Models\JobSubCategory;
use App\Notifications\JobPost;
use App\Models\CompanyLocation;
use App\Models\EducationalLevel;
use App\Models\JobCompanyLocation;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailNotificationSettings;
use App\Models\NotificationRecord;
use App\Models\Timezone;
use App\Notifications\JobDetailNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('job post.view')) {
            if ($request->ajax()) {
                $data = Job::active()->with('companyLocations','jobCategory','department')->company();
                return datatables()::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';

                        if (auth()->user()->hasPermissionTo('job post.view')) {
                            $actionBtn .= '<a class="dropdown-item viewEducation" onclick="viewJob('.$row->id.')" data-id="'.$row->id.'">View</a>';
                        }

                        if (auth()->user()->hasPermissionTo('job post.update')) {
                            $actionBtn .= '<a class="dropdown-item editEducation" href="'.route('job.edit', $row->id).'" data-id="'.$row->id.'">Edit</a>';
                        }

                        if (auth()->user()->hasPermissionTo('job post.delete')) {
                            $actionBtn .= '<a class="dropdown-item deleteEducation" onclick="deleteJob('.$row->id.')" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                        }

                        if (!auth()->user()->hasPermissionTo('job post.update') && !auth()->user()->hasPermissionTo('job post.delete')) {
                            $actionBtn = 'No Access';
                        }

                        $actionBtn .= '<a class="dropdown-item" onclick="shareDetailEmail('.$row->id.')" href="javascript:void(0)" data-id="'.$row->id.'">Share Details via Email</a>';

                        return $actionBtn;

                    })->editColumn('name', function($data) {
                        return ucfirst($data->name);

                    })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    $selectBox = '<select class="custom-select" id="status-select-' . $row->id . '" onchange="changeJobStatus(' . $row->id . ')">';
                    $selectBox .= '<option value="Open" ' . ($status === 'Open' ? 'selected' : '') . '>Open</option>';
                    $selectBox .= '<option value="Closed" ' . ($status === 'Closed' ? 'selected' : '') . '>Close</option>';
                    $selectBox .= '</select>';

                    return $selectBox;
                })
                ->addColumn('recruiter', function ($row) {
                    $recruiter = Auth::user()->name;
                    return $recruiter;
                })->filter(function ($query) use ($request) {
                    if (!empty($request->get('active'))) {
                        $query->where('status', $request->get('active'));
                    }
                    if (!empty($request->get('category'))) {
                        $query->whereHas('jobCategory', function ($q) use ($request) {
                            $q->where('job_category_id', $request->get('category'));
                        });
                    }
                    if (!empty($request->get('location'))) {
                        $query->whereHas('companyLocations', function ($q) use ($request) {
                            $q->where('id', $request->location);
                        });
                    }
                    if (!empty($request->get('department_id'))) {
                        $query->whereHas('department', function ($q) use ($request) {
                            $q->where('department_id', $request->department_id);
                        });
                    }
                    if (!empty($request->get('start_date'))) {
                            $query->where('start_date', $request->start_date);

                    }
                })->rawColumns(['checkbox','action','status','recruiter'])
                    ->make(true);
            }

            $data = Category::active()->company()->get();
            $locations = BusinessUnit::active()->company()->get();
            $country = Country::get();
            $departments = Department::active()->company()->get();
            return view('job.index',compact('country','data','locations','departments'));
        }else{
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
        if (auth()->user()->hasPermissionTo('job post.add')) {
            $company_id = Auth::user()->company_id;

            $countries = Country::get();
            $jobCategory = JobCategory::get();
            $department = Department::company()->get();
            $skills = Skill::company()->get();
            $companyLocation = BusinessUnit::company()->active()->get();
            $jobTypes = JobType::get();
            $currencies = Currency::get();
            $educations = EducationalLevel::get();
            $industry = Industry::get();
            $companyPerk = CompanyPerk::company()->get();
            $timezones = Timezone::get();
            // $countries = Country::get();

            return view('job.create',compact('industry','countries','jobCategory','department','skills','companyLocation','jobTypes','currencies','educations','companyPerk','timezones'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'job_category_id' => 'required|numeric',
            'job_sub_category_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'skill_id' => 'required',
            'location_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'job_type_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'experience' => 'required_without_all:experience_years,experience_months',
            'experience_years' => 'nullable|numeric|min:0',
            'experience_months' => 'nullable|numeric|min:0',
            'educational_level_id' => 'required',
            'company_perk_id' => 'required',
            'industry_id' => 'required|numeric',
        ]);
        $messages = [
            'experience.required_without_all' => 'The Experience field is required.',
        ];
        $validator->setCustomMessages($messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $experienceYears = $request->input('experience_years');
        $experienceMonths = $request->input('experience_months');

        $experience = $experienceYears . '.' . $experienceMonths;

        $job = Job::create($request->all());
        $job->experience = $experience;
        $job->save();

            if (is_array($request->educational_level_id)) {
                foreach ($request->educational_level_id as $educationId) {
                    JobEducation::create([
                        'job_id' => $job->id,
                        'educational_level_id' => $educationId,
                    ]);
                }
            } else {
                JobEducation::create([
                    'job_id' => $job->id,
                    'educational_level_id' => $request->educational_level_id,
                ]);
            }

            if (is_array($request->company_perk_id)) {
                foreach ($request->company_perk_id as $companyPerkId) {
                    JobCompanyPerk::create([
                        'job_id' => $job->id,
                        'company_perk_id' => $companyPerkId,
                    ]);
                }
            } else {
                JobCompanyPerk::create([
                    'job_id' => $job->id,
                    'company_perk_id' => $request->company_perk_id,
                ]);
            }

            if (is_array($request->skill_id)) {
                foreach ($request->skill_id as $skillId) {
                    JobSkill::create([
                        'job_id' => $job->id,
                        'skill_id' => $skillId,
                    ]);
                }
            }

            if (is_array($request->location_id)) {
                foreach ($request->location_id as $locationId) {
                    JobCompanyLocation::create([
                        'job_id' => $job->id,
                        'business_unit_id' => $locationId,
                    ]);
                }
            }
            $user = Auth::user();
            $details = [
                'type' =>trans('messages.job.job').' '.trans('messages.created'),
                'data' => 'New Job Post',
                'notifiable' => $user->email,
                'company_id' => $user->company_id,
                'business_unit_id' => $user->business_unit_id,
            ];

            $email = EmailSetting::company()->first();
            if($email){
                $active = EmailNotificationSettings::company()->where('title','job post notification')->active()->exists();
                if($active){
                    $user->notify(new JobPost($details));
                }
                NotificationRecord::insert($details);
            }

        return redirect()->route('job.index')->with('success', 'Job has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data= Job::active()->with('companyLocations','jobCategory','department','education','skills','companyPerks','jobType','currency','subCategory','industry')->company()->find($id);
        $newData = view('job.job-post-view',compact('data'))->render();
        return response()->json([
            'status'=>true,
            'data'=>$newData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        if (auth()->user()->hasPermissionTo('job post.update')) {
            $education = $job->education;
            $skillExits = $job->skills;
            $companyPerks = $job->companyPerks;
            $exitLocation = $job->companyLocations;
            $jobCategory = JobCategory::get();
            $sub_categories = JobSubCategory::get();
            $department = Department::get();
            $skills = Skill::get();
            $businessUnits = BusinessUnit::company()->active()->get();
            $jobTypes = JobType::get();
            $currencies = Currency::get();
            $educations = EducationalLevel::get();
            $companyPerk = CompanyPerk::get();

            $combinedExperience = $job->experience;

            $experienceParts = explode('.', $combinedExperience);

            if (count($experienceParts) === 2) {
                $years = (int)$experienceParts[0];
                $months = (int)$experienceParts[1];
            } else {
                $years = 0;
                $months = 0;
            }

            return view('job.edit', compact('jobCategory','sub_categories','department','skillExits','skills','businessUnits','jobTypes','currencies','educations','companyPerk','job','education','companyPerks','exitLocation','years','months'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'job_category_id' => 'required|numeric',
            'job_sub_category_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'skill_id' => 'required',
            'company_location_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'job_type_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'experience' => 'required_without_all:experience_years,experience_months',
            'experience_years' => 'nullable|numeric|min:0',
            'experience_months' => 'nullable|numeric|min:0',
            'educational_level_id' => 'required',
            'company_perk_id' => 'required',
            'industry_id' => 'required|numeric',
        ]);

        if ($request->input('payment_frequency') === 'range') {
            $validator = Validator::make($request->all(), [
                'minimum_salary' => 'required|numeric',
                'maximum_salary' => 'required|numeric',
                'rate' => 'required',
            ]);
        }elseif ($request->input('payment_frequency') === 'starting salary') {
            $validator = Validator::make($request->all(), [
                'starting_salary' => 'required|numeric',
                'rate' => 'required',
            ]);
        }elseif ($request->input('payment_frequency') === 'maximum salary') {
            $validator = Validator::make($request->all(), [
                'maximum_salary' => 'required|numeric',
                'rate' => 'required',
            ]);
        }elseif ($request->input('payment_frequency') === 'exact salary') {
            $validator = Validator::make($request->all(), [
                'exact_salary' => 'required|numeric',
                'rate' => 'required',
            ]);
        }

        $messages = [
            'experience.required_without_all' => 'The Experience field is required.',
        ];

        $validator->setCustomMessages($messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $experienceYears = $request->input('experience_years');
        $experienceMonths = $request->input('experience_months');
        $formattedMonths = rtrim(number_format($experienceMonths), '0.');

        $experience = $experienceYears . '.' . $formattedMonths;


        $job = Job::findOrFail($id);

        $job->is_remote_job = $request->has('is_remote_job') ? 'Yes' : 'No';
        $job->disclose_salary = $request->has('disclose_salary') ? 'Yes' : 'No';

        $job->photo = $request->has('photo') ? 'Required' : 'Not Required';
        $job->resume = $request->has('resume') ? 'Required' : 'Not Required';
        $job->dob = $request->has('dob') ? 'Required' : 'Not Required';
        $job->gender = $request->has('gender') ? 'Required' : 'Not Required';
        $job->show_recruiter = $request->has('show_recruiter') ? 'Yes' : 'No';

        $job->save();

        if (!$job) {
            return redirect()->back()->with('error', 'Job not found.');
        }

        $job->update($request->all());
        $job->experience = $experience;
        $job->save();

        $update = JobHelper::updateRelatedData($request, $job);

        return redirect()->route('job.index')->with('success', 'Job has been updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('job post.delete')) {
            Job::where('id',$id)->update(['is_active'=>'Inactive']);

            $data = Job::active()->get();
            return response()->json([
                'success' => true,
                'message' => 'Job Type deleted successfully.',
                'data' => $data,
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function changeStatus($id, $newStatus)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['error' => 'Job not found'], 404);
        }

        $job->status = $newStatus;
        $job->save();

        return response()->json(['success' => true]);
    }

    public function shareDetailEmailModal($id)
    {
        $jobData = view('job.detail-email', compact('id'))->render();
        return response()->json([
            'status' => true,
            'data' => $jobData,
            'message' => 'Otp send successfully on mobile',
        ]);
    }

    public function shareDetailEmailJob(Request $request)
    {
        $job = Job::whereId(request()->candidate_id)->first();

        $email = EmailSetting::where('company_id', Auth::user()->id)->first();

        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title', 'Job data notification')->where('is_active','Active')->exists();

            if($active){
                Notification::route('mail', $request->email)->notify( new JobDetailNotification($job));
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully',
        ]);
    }

}
