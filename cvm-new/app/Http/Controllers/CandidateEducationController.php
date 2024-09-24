<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidateEducationalDetail;
use App\Models\EducationalLevel;
use App\Models\EducationMode;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CandidateEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CandidateEducationalDetail::with('educationLevel', 'educationMode')->where('candidate_id', $request->candidate_id)->active()->get();
            return Datatables::of($data)
                ->addColumn('action', function($row){

                    $actionBtn = '<div class="action--dropdown">
                                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <img src="'. asset('images/icons/more.png').'" alt="" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">';
                                    if (auth()->user()->hasPermissionTo('educational details.update')) {
                                        $actionBtn .='<a class="dropdown-item editEducation" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                                    }
                                    if (auth()->user()->hasPermissionTo('educational details.view')) {
                                        $actionBtn .='<a class="dropdown-item viewEducation" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                                    }
                                    if (auth()->user()->hasPermissionTo('educational details.delete')) {
                                        $actionBtn .='<a class="dropdown-item deleteEducation" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                                    }
                                    $actionBtn .= '</div></div>';
                                    if (!auth()->user()->hasPermissionTo('educational details.update') && !auth()->user()->hasPermissionTo('educational details.delete')) {
                                        $actionBtn .= 'No Access';
                                    }
                    return $actionBtn;
                })
                ->editColumn('qualification', function($data){
                    return ucfirst($data->educationLevel->name);
                })
                ->editColumn('from', function($data){
                    return ($data->from_year) ? $data->from_year : 'NA';
                })
                ->editColumn('to', function($data){
                    return ($data->to_year) ? $data->to_year : 'NA';
                })
                ->editColumn('mode', function($data){
                    return $data->educationMode->name;
                })
                ->editColumn('specialization', function($data){
                    return ($data->specialization) ? $data->specialization : 'NA';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $currentTab = 'pills-educational';
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

        $input = $request->all();
        $validator = Validator::make($input,[
            'educational_level_id' => 'required',
        ]);
        if($validator->fails()){
         return response()->json($validator->errors()->tojson(),400);
        }

        CandidateEducationalDetail::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Candidate Education create successfully.',
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
        $education = CandidateEducationalDetail::with('subject', 'educationLevel', 'university', 'educationMode')->whereId($id)->first();
        return response()->json([
            'education' => $education,
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
        $education = CandidateEducationalDetail::whereId($id)->first();
        $educationalLevel = EducationalLevel::active()->company()->get();
        $subjects = Subject::active()->company()->get();
        $universities = University::active()->company()->get();
        $educationModes =   EducationMode::active()->company()->get();
        return response()->json([
            'education' => $education,
            'educationalLevel' => $educationalLevel,
            'subjects' => $subjects,
            'universities' => $universities,
            'educationModes' => $educationModes,
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
        unset($input['education_id']);
        CandidateEducationalDetail::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'education updated successfully.',
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
        CandidateEducationalDetail::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'education deleted successfully.',
        ]);
    }
}
