<?php

namespace App\Http\Controllers;

use App\Models\CandidateTraining;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CandidateTraining::with('certificate')->where('candidate_id', $request->candidate_id)->get();
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if (auth()->user()->hasPermissionTo('training details.update')) {
                        $actionBtn .='<a class="dropdown-item editTraining" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                    }
                    if (auth()->user()->hasPermissionTo('training details.view')) {
                        $actionBtn .='<a class="dropdown-item viewTraining" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                    }
                    if (auth()->user()->hasPermissionTo('training details.delete')) {
                        $actionBtn .='<a class="dropdown-item deleteTraining" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                    }
                    $actionBtn .= '</div></div>';
                    if (!auth()->user()->hasPermissionTo('training details.update') && !auth()->user()->hasPermissionTo('training details.delete')) {
                        $actionBtn .= 'No Access';
                    }
                    return $actionBtn;
                })
                ->editColumn('training', function($data){
                    return ucfirst($data->certificate->name);
                })
                ->editColumn('institute', function($data){
                    return ucfirst($data->training_center);
                })
                ->editColumn('duration', function($data){
                    return ($data->duration) ? $data->duration : 'NA';
                })
                ->editColumn('year', function($data){
                    return ($data->year_of_completion) ? $data->year_of_completion : 'NA';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $currentTab = 'pills-training';
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
        CandidateTraining::create(request()->all());
        return response()->json([
            'success' => true,
            'message' => 'Candidate Training create successfully.',
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
        $training = CandidateTraining::whereId($id)->with('certificate')->first();
        return response()->json([
            'training' => $training,
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
        $candidateTraining = CandidateTraining::whereId($id)->first();
        $certificate = Certificate::active()->company()->get();
        return response()->json([
            'candidateTraining' => $candidateTraining,
            'certificate' => $certificate,
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
        CandidateTraining::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Candidate Training updated successfully.',
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
        CandidateTraining::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Training deleted successfully.',
        ]);
    }
}
