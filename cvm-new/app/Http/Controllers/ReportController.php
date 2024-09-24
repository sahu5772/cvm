<?php

namespace App\Http\Controllers;
use App\Models\Phase;
use App\Models\Report;
use App\Models\Sector;
use App\Models\Country;
use App\Models\Subject;
use App\Models\Language;
use App\Models\Pavement;
use App\Models\Terrains;
use App\Models\Candidate;
use App\Models\Membership;
use App\Models\Certificate;
use App\Models\Designation;
use Illuminate\Support\Str;
use App\Models\ContractMode;
use Illuminate\Http\Request;
use App\Models\FundingAgency;
use App\Models\ProjectReport;
use App\Models\CandidateProject;
use App\Models\EducationalLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('reports.view')) {
            if ($request->ajax()) {
                $data = Candidate::where('candidates.company_id',Auth::user()->company_id)->with('project','membership','educationalDetail','training','designation','language','department','country');
                return datatables()::of($data)->addIndexColumn()

                ->addColumn('first_name', function (Candidate $data) {
                    return '<a href='.route('candidate.show', $data->id).'>'.$data->first_name.'</a>';
                })
                ->addColumn('designation', function (Candidate $data) {
                    return $data->designation->name;
                })
                ->addColumn('language', function (Candidate $lang) {
                    return $lang->language->name;
                })
                ->addColumn('department', function (Candidate $lang) {
                    return $lang->department->name;
                })
                ->addColumn('nationality', function (Candidate $con) {
                    return $con->country->name;
                })
                ->filter(function ($query) use ($request) {
                    if (!empty($request->get('minAge')) && !empty($request->get('maxAge'))) {
                        $startDate = date('Y-m-d', strtotime("-".$request->minAge." year", strtotime(date('Y-m-d'))));
                        $endDate = date('Y-m-d', strtotime("-".$request->maxAge." year", strtotime(date('Y-m-d'))));
                        $query->where('dob', '<=', $startDate)
                        ->where('dob', '>=', $endDate);
                    }
                    if (!empty($request->get('minExp')) && !empty($request->get('maxExp'))) {
                        $query->where('total_experience', '>=', $request->get('minExp'))
                        ->where('total_experience', '<=', $request->get('maxExp'));
                    }
                    if (!empty($request->get('country_id'))) {
                        $query->whereIn('country_id', $request->get('country_id'));
                    }
                    if (!empty($request->get('gender'))) {
                        $query->whereIn('gender', $request->get('gender'));
                    }
                    if (!empty($request->get('language'))) {
                        $query->whereIn('language_known', $request->get('language'));
                    }
                    if (!empty($request->get('educational_level_id'))) {

                        $query->whereHas('educationalDetail', function ($q) use ($request) {
                            $q->whereIn('educational_level_id', $request->educational_level_id);
                        });
                    }
                    if (!empty($request->get('subject_id'))) {

                        $query->whereHas('educationalDetail', function ($q) use ($request) {
                            $q->whereIn('subject_id', $request->subject_id);
                        });
                    }
                    if (!empty($request->get('designation_id'))) {
                        $query->where('designation_id', $request->get('designation_id'));
                    }
                    if (!empty($request->get('certificate_id'))) {
                        $query->whereHas('training', function ($q) use ($request) {
                            $q->whereIn('certificate_id', $request->certificate_id);
                        });
                    }
                    if (!empty($request->get('intExperience'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            if($request->intExperience == 'yes'){
                                $q->where('project_type', 'International');
                            }elseif($request->intExperience == 'no'){
                                $q->where('project_type', 'National');
                            }else{
                                $q->whereIn('project_type', ['National','International']);
                            }
                        });
                    }
                    if (!empty($request->get('membership_id'))) {
                        $query->whereHas('membership', function ($q) use ($request) {
                            $q->whereIn('membership_id', $request->membership_id);
                        });
                    }

                })->rawColumns(['designation','language','first_name'])->make(true);
            }
            $designations = Designation::where('company_id',Auth::user()->company_id)->get();
            $educationalLevels = EducationalLevel::where('company_id',Auth::user()->company_id)->get();
            $country = Country::get();
            $languages = Language::get();
            $sectors = Sector::where('company_id',Auth::user()->company_id)->get();
            $phases = Phase::where('company_id',Auth::user()->company_id)->get();
            $certificates = Certificate::where('company_id',Auth::user()->company_id)->get();
            $memberships = Membership::where('company_id',Auth::user()->company_id)->get();
            $educations = Subject::where('company_id',Auth::user()->company_id)->get();
            return view('report.index',compact('country','designations','languages','educationalLevels','sectors','phases','certificates','memberships','educations'));
        }else{
            return redirect()->route('home');
        }
    }
    public function projectReport(Request $request)
    {

        if (auth()->user()->hasPermissionTo('reports.view')) {
            if ($request->ajax()) {
                $data = CandidateProject::where('candidate_projects.company_id',Auth::user()->company_id)->with('country','candidate','designation','industry','sector','phase');
                return datatables()::of($data)->addIndexColumn()
                ->addColumn('candidate', function (CandidateProject $project) {
                    $btn = '<a href='.route('candidate.show', $project->candidate_id).'>'.$project->candidate->first_name.' '.$project->candidate->last_name.'</a>';
                    return $btn;

                })
                ->addColumn('designation', function (CandidateProject $project) {
                    return $project->designation ? $project->designation->name : '';
                })
                ->addColumn('industry', function (CandidateProject $project) {
                    return $project->industry?$project->industry->name :'';
                })
                ->addColumn('sector', function (CandidateProject $project) {
                    return $project->sector?$project->sector->name : '';
                })
                ->addColumn('phase', function (CandidateProject $project) {
                    return $project->phase?$project->phase->name:'';
                })
                ->filter(function ($query) use ($request) {

                    if (!empty($request->get('country_id'))) {
                        $query->where('country_id', $request->get('country_id'));
                    }
                    if (!empty($request->get('designation_id'))) {
                        $query->where('designation_id', $request->get('designation_id'));
                    }
                    if (!empty($request->get('funding_agency_id'))) {
                        $query->where('funding_agency_id', $request->get('funding_agency_id'));
                    }
                    if (!empty($request->get('phase_id'))) {
                        $query->where('phase_id', $request->get('phase_id'));
                    }
                    if (!empty($request->get('sector_id'))) {
                        $query->where('sector_id', $request->get('sector_id'));
                    }
                    if (!empty($request->get('contract_mode_id'))) {
                        $query->where('contract_mode_id', $request->get('contract_mode_id'));
                    }
                    if (!empty($request->get('terrain_id'))) {
                        $query->where('terrain_id', $request->get('terrain_id'));
                    }
                    if (!empty($request->get('intExperience'))) {
                        if($request->intExperience == 'yes'){
                            $query->where('project_type', 'International');
                        }elseif($request->intExperience == 'no'){
                            $query->where('project_type', 'National');
                        }else{
                            $query->whereIn('project_type', ['National','International']);
                        }
                    }

                    })
                    // ->addColumn('action', function($row){

                    // })
                    // ->addColumn('action', function($row){
                    //     $actionBtn = '<a href="javascript:void(0)" class="btn btn-success btn-sm" >Edit</a>
                    //     <a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
                    //     return $actionBtn;
                    // })

                    ->rawColumns(['candidate','designation','industry','sector','phase'])->make(true);
            }
            $designations = Designation::where('company_id',Auth::user()->company_id)->get();
            $country = Country::get();
            $sectors = Sector::where('company_id',Auth::user()->company_id)->get();
            $phases = Phase::where('company_id',Auth::user()->company_id)->get();
            $fundingAgency = FundingAgency::where('company_id',Auth::user()->company_id)->get();
            $pavements = Pavement::where('company_id',Auth::user()->company_id)->get();
            $contracts = ContractMode::where('company_id',Auth::user()->company_id)->get();
            $terrains = Terrains::where('company_id',Auth::user()->company_id)->get();

            return view('report.project-report',compact('country','designations','sectors','phases','fundingAgency','pavements','contracts','terrains'));
        }else{
            return redirect()->route('home');
        }
    }
    public function employeeReport(Request $request)
    {
        if ($request->ajax()) {
            $data = Candidate::where('company_id',Auth::user()->company_id)->with('membership','educationalDetail','training');
            return datatables()::of($data)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('minAge')) && !empty($request->get('maxAge'))) {
                    $startDate = date('Y-m-d', strtotime("-".$request->minAge." year", strtotime(date('Y-m-d'))));
                    $endDate = date('Y-m-d', strtotime("-".$request->maxAge." year", strtotime(date('Y-m-d'))));
                     $query->where('dob', '<=', $startDate)
                     ->where('dob', '>=', $endDate);
                }
                if (!empty($request->get('minExp')) && !empty($request->get('maxExp'))) {

                     $query->where('dob', '<=', $request->get('minExp'))
                     ->where('dob', '>=', $request->get('maxExp'));
                }
                if (!empty($request->get('country_id'))) {
                    $query->where('country_id', $request->get('country_id'));
                }
                // if (!empty($request->get('pavement_id'))) {
                //     $query->where('pavement_id', $request->get('pavement_id'));
                // }

                if (!empty($request->get('funding_agency_id'))) {
                    $query->where('funding_agency_id', $request->get('funding_agency_id'));
                }
                if (!empty($request->get('gender'))) {
                    $query->where('gender', $request->get('gender'));
                }
                if (!empty($request->get('language'))) {
                    $query->where('language_known', $request->get('language'));
                }
                if (!empty($request->get('educational_level_id'))) {

                    $query->whereHas('educationalDetail', function ($q) use ($request) {
                        $q->where('educational_level_id', $request->educational_level_id);
                    });
                }
                if (!empty($request->get('designation_id'))) {
                    $query->where('designation_id', $request->get('designation_id'));
                }
                if (!empty($request->get('certificate_id'))) {
                    $query->whereHas('training', function ($q) use ($request) {
                        $q->where('certificate_id', $request->certificate_id);
                    });
                }
                if (!empty($request->get('membership_id'))) {
                    $query->whereHas('membership', function ($q) use ($request) {
                        $q->where('membership_id', $request->membership_id);
                    });
                }

            })->addColumn('action', function($row){

                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                 return $btn;

                })->rawColumns(['action'])->make(true);
        }
        $designations = Designation::where('company_id',Auth::user()->company_id)->get();
        $educationalLevels = EducationalLevel::where('company_id',Auth::user()->company_id)->get();
        $country = Country::get();
        $languages = Language::get();
        $sectors = Sector::where('company_id',Auth::user()->company_id)->get();
        $phases = Phase::where('company_id',Auth::user()->company_id)->get();
        $certificates = Certificate::where('company_id',Auth::user()->company_id)->get();
        $memberships = Membership::where('company_id',Auth::user()->company_id)->get();
        return view('report.employee-report',compact('country','designations','languages','educationalLevels','sectors','phases','certificates','memberships'));
    }

}
