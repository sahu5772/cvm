<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Sector;
use App\Models\Country;
use App\Models\JobType;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Industry;
use App\Models\Language;
use App\Models\Terrains;
use App\Models\Candidate;
use App\Models\CandidateCv;
use App\Models\Department;
use App\Models\Membership;
use App\Models\University;
use App\Models\Certificate;
use App\Models\Designation;
use App\Models\EmailSetting;
use App\Models\EmployerType;
use Illuminate\Http\Request;
use App\Models\EducationMode;
use App\Models\FundingAgency;
use App\Models\KeywordRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CandidateKeyword;
use App\Models\CandidateProject;
use App\Models\EducationalLevel;
use App\Models\CandidateTraining;
use App\Notifications\WelcomeMail;
use App\Models\CandidateMembership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CandidateEducationalDetail;
use App\Models\ContractMode;
use App\Models\EmailNotificationSettings;
use App\Models\NotificationRecord;
use App\Notifications\NotificationExample;
use App\Notifications\CandidateCreate;
use App\Notifications\CandidateDetailNotification;
use Illuminate\Support\Facades\Notification;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $candidates = Candidate::with('workExperience.designation', 'educationalDetail.educationLevel', 'educationalDetail.subject', 'educationalDetail.university', 'designation')->active()->company()->orderBy('created_at', 'desc')->simplePaginate(5);
        return view('candidate.index', compact('candidates'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->hasPermissionTo('candidate.add')) {
            $languages = Language::active()->company()->get();
            $countries = Country::get();
            $designations = Designation::active()->company()->get();
            $departments = Department::active()->company()->get();
            return view('candidate.create', compact('languages', 'countries', 'designations', 'departments'));
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
            'first_name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:candidates,email',
            'dob' => 'required|date|before:18 years ago',
            'phone_number' => ['required', 'digits:10'],
            'language_known' => 'required',
            'country_id' => 'required',
            'designation_id' => 'required',
            'department_id' => 'required',
        ]);

        $input = request()->all();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $source = time() . rand(11111, 99999) . '.' . $profileImage->getClientOriginalExtension();
            $destinationPath = public_path('images/candidate');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $profileImage->move($destinationPath, $source);
            $input['profile_image'] = $source;
        }

        $candidate = Candidate::create($input);

        if ($request->hasFile('file')) {
            $profileImage = $request->file('file');
            $source = time() . rand(11111, 99999) . '.' . $profileImage->getClientOriginalExtension();
            $destinationPath = public_path('images/candidate/cv');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $profileImage->move($destinationPath, $source);
            $input['file'] = $source;
            $input['candidate_id'] = $candidate->id;
        }

        $candidate = CandidateCv::create($input);

        $candidateId = $candidate->id;
        $details = [
            'type' => trans('messages.candidate.create'),
            'data' => 'your profile created',
            'notifiable' => $candidate->email,
            'company_id' => $candidate->company_id,
            'business_unit_id' => $candidate->business_unit_id,
        ];

        $email = EmailSetting::where('company_id',Auth::user()->id)->first();
        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title','create candidate notification')->where('is_active','Active')->exists();
            if($active){
                $candidate->notify(new CandidateCreate($details));
            }
            NotificationRecord::insert($details);
        }

        return redirect()->route('candidate.index')->with('success',trans('messages.candidate.create_candidate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::whereId($id)->with('project', 'training', 'membership','cvs')->first();
        $currentTab = (request()->tab) ? request()->tab : 'pills-profile';
        switch ($currentTab) {
            case 'pills-personal':
                $languages = Language::active()->company()->get();
                $countries = Country::get();
                $designations = Designation::active()->company()->get();
                $departments = Department::active()->company()->get();
                return view('candidate.view', compact('departments', 'designations', 'candidate', 'currentTab', 'languages', 'countries'));
                break;
            case 'pills-educational':
                $qualifications = EducationalLevel::company()->get();
                $subjects = Subject::active()->company()->get();
                $universities = University::active()->company()->get();
                $educationModes = EducationMode::active()->company()->get();
                return view('candidate.view', compact('educationModes', 'universities', 'candidate', 'currentTab', 'qualifications', 'subjects'));
                break;
            case 'pills-professional':
                $designations = Designation::active()->company()->get();
                $countries = Country::get();
                $types = JobType::active()->company()->get();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'designations', 'countries', 'types'));
                break;
            case 'pills-keywords':
                $keywords = CandidateKeyword::where('candidate_id',$id)->first();
                $industries = Industry::company()->active()->get();
                $sectors = Sector::orWhere('industry_id',$keywords?$keywords->industry_id:'')->company()->active()->get();
                $phases = Phase::orWhere('sector_id',$keywords?$keywords->sector_id:'')->company()->active()->get();
                $keywordData = Keyword::orWhere('phase_id',$keywords?$keywords->phase_id:'')->active()->get();
                $keywordRecord = KeywordRecord::orWhere('candidate_id',$keywords?$keywords->candidate_id:'')->first();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'industries', 'sectors', 'phases','keywords','keywordData','keywordRecord'));
                break;
            case 'pills-project':
                $designations = Designation::active()->company()->get();
                $industries = Industry::company()->active()->get();
                $employerType = EmployerType::company()->active()->get();
                $countries = Country::get();
                $fundingAgencies = FundingAgency::company()->active()->get();
                $contractModes= ContractMode::company()->active()->get();
                $terrains = Terrains::company()->active()->get();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'designations', 'contractModes', 'countries', 'industries', 'employerType', 'fundingAgencies', 'terrains'));
                break;
            case 'pills-training':
                $certificates = Certificate::active()->company()->get();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'certificates'));
                break;
            case 'pills-member':
                $memberships = Membership::active()->company()->get();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'memberships'));
                break;
            case 'pills-address':
                $countries = Country::get();
                return view('candidate.view', compact( 'candidate', 'currentTab', 'countries'));
                break;
            default:
                $projects = CandidateProject::where('candidate_id', $id)->with('designation')->limit(2)->get();
                $trainings = CandidateTraining::where('candidate_id', $id)->with('certificate')->limit(1)->get();
                $eduction = CandidateEducationalDetail::where('candidate_id', $id)->with('educationLevel', 'subject')->limit(2)->get();
                $membership = CandidateMembership::where('candidate_id', $id)->with('membership')->limit(2)->get();
                $keywords = CandidateKeyword::where('candidate_id', $id)->with('keyword')->get();
                return view('candidate.view', compact('candidate', 'currentTab', 'projects', 'trainings', 'eduction', 'membership', 'keywords'));
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        if (auth()->user()->hasPermissionTo('candidate.update')) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:candidates,email,' . $candidate->id,
                'dob' => 'required|date|before:18 years ago',
                'phone_number' => 'required|numeric',
                'language_known' => 'required',
                'country_id' => 'required',
                'designation_id' => 'required',
                'department_id' => 'required',
            ]);

            $input = request()->all();

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');
                $source = time() . rand(11111, 99999) . '.' . $profileImage->getClientOriginalExtension();
                $destinationPath = public_path('images/candidate');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }
                $profileImage->move($destinationPath, $source);
                $input['profile_image'] = $source;
            }

            $candidate->update($input);

            return response()->json([
                'message' => 'Data Updated Successfully'
            ]);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidate  $candidate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        //
    }

    function downloadInvoice($id){
        $candidate = Candidate::whereId($id)->with('project', 'training', 'membership')->first();
        $pdf = Pdf::loadView('template.cv',array('candidate'=>$candidate));
        return $pdf->download('cv.pdf');
    }

    function VerifyPhone(Request $request){
        $candidate = Candidate::whereId($request->candidate_id)->active()->company()->first();
        $rand = 123456;
        $candidate->otp  = $rand;
        $candidate->update();
        $candidateData = view('candidate.mobile-verify', compact('candidate'))->render();
        return response()->json([
            'status' => true,
            'data' => $candidateData,
            'message' => 'Otp send successfully on mobile',
        ]);
    }

    function resendOtp(Request $request){
        if ($request->ajax()) {
            $candidate = Candidate::whereId($request->candidate_id)->active()->company()->first();
            // $rand = rand(000000,999999);
            $rand = 123456;
            $candidate->otp  = $rand;
            $candidate->update();
            return response()->json([
                'status' => true,
                'message' => 'Otp Resend Successfully On Mobile',
            ]);

        }

    }

    function resendOtpEmail(Request $request){
        if ($request->ajax()) {
            $candidate = Candidate::whereId($request->candidate_id)->active()->company()->first();
            // $rand = rand(000000,999999);
            $rand = 123456;
            $candidate->otp  = $rand;
            $candidate->update();
            return response()->json([
                'status' => true,
                'message' => 'Otp Resend Successfully On Email',
            ]);

        }

    }

    function verifyOtp(Request $request){
            $candidate = Candidate::whereId($request->candidate_id)->where('otp',$request->otp)->active()->company()->first();
            if(isset($candidate)){
            $candidate->is_email_verified  = '1';
            $candidate->update();

            $details = [
                'title' => trans('messages.company.create_company'),
                'message' => 'CVM : Use TOP '.$request->otp.' to log in to your account DO NOT SHARE this  code  with anyone.',
            ];

            $email = EmailSetting::where('company_id',Auth::user()->company_id)->first();
            if($email){
                $candidate->notify(new WelcomeMail($details));
            }

            return response()->json([
                'status' => true,
                'message' => 'Candidate verify successfully',
            ]);
            }else{
                return response()->json([
                'status' => false,
                'errors' => 'Please enter correct otp',
                 ]);
            }

    }

    function VerifyEmail(Request $request){
        if ($request->ajax()) {
            $candidate = Candidate::whereId($request->candidate_id)->active()->company()->first();
            // $rand = rand(000000,999999);
            $rand = 123456;
            $candidate->otp  = $rand;
            $candidate->update();
            $candidateData = view('candidate.email-verify', compact('candidate'))->render();
            return response()->json([
                'status' => true,
                'data' => $candidateData,
                'message' => 'Otp Send Successfully On Email',
            ]);
        }
    }

    function shareDetailEmailModal($id){
        $candidateData = view('candidate.detail-email', compact('id'))->render();
        return response()->json([
            'status' => true,
            'data' => $candidateData,
            'message' => 'Otp send successfully on mobile',
        ]);
    }

    function shareDetailEmail(Request $request)
    {
        $candidate = Candidate::whereId(request()->candidate_id)->first();

        $details = [
            'type' => 'candidate data notification',
            'data' => 'candidate detail',
            'notifiable' => $candidate->email,
            'company_id' => $candidate->company_id,
            'business_unit_id' => $candidate->company_id,
        ];

        $email = EmailSetting::where('company_id',Auth::user()->id)->first();
        if($email){
            $active = EmailNotificationSettings::where('company_id',Auth::user()->id)->where('title','candidate data notification')->where('is_active','Active')->exists();
            if($active){
                Notification::route('mail', $request->email)->notify( new CandidateDetailNotification($candidate));
            }
            NotificationRecord::insert($details);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully',
        ]);
    }
}
