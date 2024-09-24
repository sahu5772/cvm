<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Sector;
use App\Models\Country;
use App\Models\Heading;
use App\Models\Keyword;
use App\Models\Subject;
use App\Models\Language;
use App\Models\Pavement;
use App\Models\Terrains;
use App\Models\Candidate;
use App\Models\Membership;
use App\Models\Certificate;
use App\Models\Designation;
use App\Models\ContractMode;
use Illuminate\Http\Request;
use App\Models\FundingAgency;
use App\Models\ProjectReport;
use App\Models\EducationalLevel;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Session;

class SearchFilterController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('search resumes.view')) {
            if ($request->ajax()) {
                $data = Candidate::where('candidates.company_id',Auth::user()->company_id)->with('getKeywordRecord','project','project.sector','membership','educationalDetail','training','designation','language','department','country','workExperience.country');
                return datatables()::of($data)->addIndexColumn()

                ->addColumn('first_name', function (Candidate $data) {
                    return '<a href='.route('candidate.show', $data->id).'>'.$data->first_name.'</a>';
                })

                ->addColumn('designation', function (Candidate $data) {
                    return $data->designation?$data->designation->name:'NA';
                })
                ->addColumn('language', function (Candidate $lang) {
                    return $lang->language?$lang->language->name:'NA';
                })
                ->addColumn('department', function (Candidate $department) {
                    return $department->department?$department->department->name:'NA';
                })
                ->addColumn('nationality', function (Candidate $country) {
                    return $country->country->name;
                })
                ->addColumn('countryExperience', function (Candidate $candidate) {
                    $countryNames = $candidate->workExperience->pluck('country.name')->filter()->implode(', ');
                    return $countryNames ?: 'NA';
                })
                ->addColumn('nationality', function (Candidate $country) {
                    return $country->country->name;
                })
                ->addColumn('project', function (Candidate $val) {
                if(count($val->project)>0){
                return $val->project->map(function($sec) {
                return $sec->sector?$sec->sector->name:'NA';
                })->implode(',');
                }else{
                    return 'NA';
                }
                })
                ->addColumn('phase', function (Candidate $val) {
                if(count($val->project)>0){
                return $val->project->map(function($phase) {
                return $phase->phase?$phase->phase->name : 'NA';
                })->implode(',');
                }else{
                    return 'NA';
                }
                })
                ->addColumn('fundingAgency', function (Candidate $agency) {
                if(count($agency->project)>0){
                return $agency->project->map(function($value) {

                return $value->fundingAgency?$value->fundingAgency->name:'NA';
                })->implode(',');
                }else{
                    return 'NA';
                }
                })
                ->addColumn('terrain', function (Candidate $value) {
                if(count($value->project)>0){
                return $value->project->map(function($value) {

                return $value->terrain?$value->terrain->name:'NA';
                })->implode(',');
                }else{
                    return 'NA';
                }
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
                    if (!empty($request->get('ex_country_id'))) {
                        $query->whereHas('workExperience', function ($subQuery) use ($request) {
                            $subQuery->whereIn('country_id', $request->get('ex_country_id'));
                        });
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
                    if (!empty($request->get('membership_id'))) {
                        $query->whereHas('membership', function ($q) use ($request) {
                            $q->whereIn('membership_id', $request->membership_id);
                        });
                    }
                    if (!empty($request->get('sector_id'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            $q->whereIn('sector_id', $request->sector_id);
                        });
                    }
                    if (!empty($request->get('phase_id'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            $q->whereIn('phase_id', $request->phase_id);
                        });
                    }
                    if (!empty($request->get('terrain_id'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            $q->whereIn('terrain_id', $request->terrain_id);
                        });
                    }
                    if (!empty($request->get('contract_mode_id'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            $q->whereIn('contract_mode_id', $request->contract_mode_id);
                        });
                    }
                    if (!empty($request->get('funding_agency_id'))) {
                        $query->whereHas('project', function ($q) use ($request) {
                            $q->whereIn('funding_agency_id',$request->get('funding_agency_id'));
                        });
                    }

                    if (!empty($request->get('latestDesigInput'))) {
                        $query->orderBy('designation_id','DESC');
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

                if (!is_null($request->get('customtext'))) {
                    $check =true;
                    if($request->get('searchType') == 'all'){
                        $textDAta =  array_filter(explode(',',$request->get('customtext')));
                        foreach($textDAta as $dataVal){
                            $keyT = Keyword::where('keyword',$dataVal)->first();

                        if(is_null($keyT)){
                            $check = false;
                            break;
                        }
                        }
                        if($check){
                        $query->whereHas('getKeywordRecord', function ($q) use ($request) {
                            $searchValue =  array_filter(explode(',',$request->get('customtext')));
                        $q->whereIn('keyword',$searchValue);
                        });
                        }else{
                            $query->whereHas('getKeywordRecord', function ($q) use ($request) {
                            $q->where('keyword','na');
                            });
                        }
                    }else{
                        $query->whereHas('getKeywordRecord', function ($q) use ($request) {
                        $searchValue =  array_filter(explode(',',$request->get('customtext')));
                        $q->whereIn('keyword',$searchValue);
                        });
                    }
                }
                })->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                    })->rawColumns(['action','language','phase','fundingAgency','nationality','designation','first_name'])->make(true);
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

            $fundingAgency = FundingAgency::where('company_id',Auth::user()->company_id)->get();
            $pavements = Pavement::where('company_id',Auth::user()->company_id)->get();
            $contracts = ContractMode::where('company_id',Auth::user()->company_id)->get();
            $terrains = Terrains::where('company_id',Auth::user()->company_id)->get();
            return view('search.index',compact('terrains','contracts','pavements','fundingAgency','country','designations','languages','educationalLevels','sectors','phases','certificates','memberships','educations'));
        }else{
            return redirect()->route('home');
        }
    }

    public function filter(Request $request){
        // dd($request->all());
    Session::forget('filter');
    Session::put('filter', '');
    $data=$request->all();
    Session::put('filter', $data);
    return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }


}
