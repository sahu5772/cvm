<?php

namespace App\Http\Controllers;

use App\Models\CandidateProject;
use App\Models\City;
use App\Models\ContractMode;
use App\Models\Country;
use App\Models\Designation;
use App\Models\EmployerType;
use App\Models\FundingAgency;
use App\Models\Industry;
use App\Models\Phase;
use App\Models\Sector;
use App\Models\State;
use App\Models\Terrains;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CandidateProject::with('designation', 'industry', 'sector')->where('candidate_id', $request->candidate_id)->active()->get();
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if (auth()->user()->hasPermissionTo('project details.update')) {
                        $actionBtn .='<a class="dropdown-item editProject" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                    }
                    if (auth()->user()->hasPermissionTo('project details.view')) {
                        $actionBtn .='<a class="dropdown-item viewProject" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                    }
                    if (auth()->user()->hasPermissionTo('project details.delete')) {
                        $actionBtn .='<a class="dropdown-item deleteProject" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                    }
                    $actionBtn .= '</div></div>';
                    if (!auth()->user()->hasPermissionTo('project details.update') && !auth()->user()->hasPermissionTo('project details.delete')) {
                        $actionBtn .= 'No Access';
                    }
                    return $actionBtn;
                })
                ->editColumn('project', function($data){
                    return ucfirst($data->name);
                })
                ->editColumn('from', function($data){
                    return ($data->from) ? $data->from : 'NA';
                })
                ->editColumn('to', function($data){
                    return ($data->to) ? $data->to : 'NA';
                })
                ->editColumn('designation', function($data){
                    return ($data->designation) ? $data->designation->name : 'NA';
                })
                ->editColumn('industry', function($data){
                    return ($data->industry) ? $data->industry->name : 'NA';
                })
                ->editColumn('sector', function($data){
                    return ($data->sector) ? $data->sector->name : 'NA';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $currentTab = 'pills-project';
        return view('candidate.view', compact('currentTab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CandidateProject::create(request()->all());

        return response()->json([
            'success' => true,
            'message' => 'Candidate project create successfully.',
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
        $project = CandidateProject::with('fundingAgency', 'contractMode', 'terrain', 'designation', 'industry', 'sector', 'phase', 'employerType', 'country', 'state', 'city')->whereId($id)->first();
        return response()->json([
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidateProject = CandidateProject::whereId($id)->first();
        $designation = Designation::active()->company()->get();
        $industry = Industry::active()->company()->get();
        $fundingAgencies = FundingAgency::active()->company()->get();
        $countries = Country::get();
        $states = State::get();
        $cities = City::get();
        $contractMode = ContractMode::active()->company()->get();
        $terrains = Terrains::active()->company()->get();
        $sector = Sector::active()->company()->get();
        $phase = Phase::active()->company()->get();
        $employeeType = EmployerType::active()->company()->get();
        return response()->json([
            'candidateProject' => $candidateProject,
            'designation' => $designation,
            'industry' => $industry,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'fundingAgencies' => $fundingAgencies,
            'contractMode' => $contractMode,
            'terrains' => $terrains,
            'sector' => $sector,
            'phase' => $phase,
            'employeeType' => $employeeType,
        ]);
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
        $input = request()->all();
        unset($input['_method']);
        unset($input['_token']);
        CandidateProject::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Candidate Project updated successfully.',
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
        CandidateProject::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }

    public function phaseList() {
        $data['phase'] = Phase::where('sector_id', request()->id)->active()->get();
        return response()->json($data);
    }
}
