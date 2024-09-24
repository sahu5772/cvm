<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('skill.view')) {
            if ($request->ajax()) {
                $data = Skill::active()->get();
                $sillsData = view('skills.data', compact('data'))->render();

                return response()->json([
                    'status' => true,
                    'data' => $sillsData,
                ]);
            }

            return view('education.skill');
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
            'name' => 'required|unique:skills,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
       Skill::create($request->all());

       $data = Skill::active()->get();
       $sillsData = view('skills.data', compact('data'))->render();

        return response()->json([
            'message' => 'Skill created successfully',
            'status'=>true,
            'data'=>$sillsData,
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
        if (auth()->user()->hasPermissionTo('skill.delete')) {
            Skill::where('id',$id)->update(['is_active'=>'Inactive']);

            $data = Skill::active()->get();
            $sillsData = view('skills.data', compact('data'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Company Location deleted successfully.',
                'data' => $sillsData,
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
