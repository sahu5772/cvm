<?php

namespace App\Http\Controllers;

use App\Models\CandidateWorkExperience;
use App\Models\Country;
use App\Models\Designation;
use App\Models\JobType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateWorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CandidateWorkExperience::with('designation')->where('candidate_id', $request->candidate_id)->active()->get();

            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if (auth()->user()->hasPermissionTo('professional details.update')) {
                        $actionBtn .='<a class="dropdown-item editExperience" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                    }
                    if (auth()->user()->hasPermissionTo('professional details.view')) {
                        $actionBtn .='<a class="dropdown-item viewExperience" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                    }
                    if (auth()->user()->hasPermissionTo('professional details.delete')) {
                        $actionBtn .='<a class="dropdown-item deleteExperience" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                    }
                    $actionBtn .= '</div></div>';
                    if (!auth()->user()->hasPermissionTo('professional details.update') && !auth()->user()->hasPermissionTo('professional details.delete')) {
                        $actionBtn .= 'No Access';
                    }
                    return $actionBtn;
                })
                ->editColumn('company', function($data){
                    return ucfirst($data->company_name);
                })
                ->editColumn('from', function($data){
                    return ($data->from_date) ? $data->from_date : 'NA';
                })
                ->editColumn('to', function($data){
                    return ($data->to_date) ? $data->to_date : 'Currently working';
                })
                ->editColumn('designation', function($data){
                    return $data->designation->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $currentTab = 'pills-professional';
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
        CandidateWorkExperience::create(request()->all());
        return response()->json([
            'success' => true,
            'message' => 'Candidate Education create successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CandidateWorkExperience  $candidateWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidateWorkExperience = CandidateWorkExperience::whereId($id)->with('designation', 'country', 'jobType')->first();
        return response()->json([
            'candidateWorkExperience' => $candidateWorkExperience,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CandidateWorkExperience  $candidateWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidateWorkExperience = CandidateWorkExperience::whereId($id)->first();
        $designation = Designation::active()->company()->get();
        $jobType = JobType::active()->company()->get();
        $country = Country::get();
        return response()->json([
            'candidateWorkExperience' => $candidateWorkExperience,
            'designation' => $designation,
            'country' => $country,
            'jobType' => $jobType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CandidateWorkExperience  $candidateWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = request()->all();
        unset($input['_method']);
        unset($input['_token']);
        CandidateWorkExperience::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Candidate Work Experience updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateWorkExperience  $candidateWorkExperience
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CandidateWorkExperience::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience  deleted successfully.',
        ]);
    }
}
