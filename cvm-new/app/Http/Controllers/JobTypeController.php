<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\JobType;
use DataTables;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('job type.view')) {
            if ($request->ajax()) {
            $data = JobType::active()->company()->get();
            $jobTypeData = view('job.data', compact('data'))->render();
            return response()->json([
                'status' => true,
                'data' => $jobTypeData,
            ]);
        }
            return view('setting.job-type');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $jobType = JobType::create([
            'name' => $request->name,
            'company_id' => auth()->user()->company_id,
            'is_active' => $request->is_active,
            'created_at' => $currentDate,
            'created_by' => auth()->user()->id
        ]);

        $data = JobType::active()->get();
        $jobTypeData = view('job.data', compact('data'))->render();
        return response()->json([
            'success' => true,
            'message' => 'Job Type Create successfully.',
            'data' => $jobTypeData,
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

        return view('job.edit');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('job type.delete')) {
            JobType::where('id',$id)->update(['is_active'=>'Inactive']);

            $data = JobType::active()->get();
            $jobTypeData = view('job.data', compact('data'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Job Type deleted successfully.',
                'data' => $jobTypeData,
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
