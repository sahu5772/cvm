<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\EducationalLevel;
use DataTables;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('education level.view')) {
            if ($request->ajax()) {
                $data = EducationalLevel::active()->get();
                $educLevelData = view('job.data', compact('data'))->render();
                return response()->json([
                    'status' => true,
                    'data' => $educLevelData,
                ]);
            }
            return view('education.education-level');
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
            'name' => 'required|unique:educational_levels,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $educLevel = EducationalLevel::create([
            'name' => $request->name,
            'created_at' => $currentDate,
            'created_by' => auth()->user()->id
        ]);

        $data = EducationalLevel::active()->get();
        $educLevelData = view('job.data', compact('data'))->render();
        return response()->json([
            'success' => true,
            'message' => 'Educational Level Created successfully.',
            'data' => $educLevelData,
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
        //
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
        if (auth()->user()->hasPermissionTo('education level.delete')) {
            EducationalLevel::where('id', $id)->update(['is_active' => 'Inactive']);

            $data = EducationalLevel::active()->get();
            $educLevelData = view('job.data', compact('data'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Educational Level deleted successfully.',
                'data' => $educLevelData,
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
