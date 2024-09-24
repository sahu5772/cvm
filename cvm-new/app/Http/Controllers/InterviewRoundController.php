<?php

namespace App\Http\Controllers;

use App\Models\InterviewRound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;

class InterviewRoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('department.view')) {
            if ($request->ajax()) {
                $data = InterviewRound::company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                                if (auth()->user()->hasPermissionTo('department.update')) {
                                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="editInterviewRound(' . $row->id . ')" >Edit</a>';
                                }

                                if (auth()->user()->hasPermissionTo('department.delete')) {
                                    if ($actionBtn !== '') {
                                        $actionBtn .= ' ';
                                    }
                                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteInterviewRound(' . $row->id . ')" >Delete</a>';
                                }

                                if ($actionBtn === '') {
                                    $actionBtn = 'You have no access';
                                } elseif (!auth()->user()->hasPermissionTo('department.update')) {
                                    $actionBtn = 'No Access for edit'.$actionBtn;
                                } elseif (!auth()->user()->hasPermissionTo('department.delete')) {
                                    $actionBtn .= 'No Access for delete';
                                }
                                $actionBtn .= '</div></div>';
                                return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('interviewRound.index');
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
            'name' => 'required|unique:interview_rounds,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $department = InterviewRound::create([
            'name' => $request->name,
            'color' => $request->color
        ]);

        return response()->json([
            'message' => 'Interview Round created successfully',
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
        if (auth()->user()->hasPermissionTo('department.update')) {
            $interview= InterviewRound::find($id);
            return response()->json(['data' => $interview]);
        }else{
            return redirect()->route('home');
        }
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $interview = InterviewRound::findOrFail($id);

        $interview->name = $request->input('name');
        $interview->color = $request->input('color');
        $interview->save();

        return response()->json(['message' => 'Interview Round updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterviewRound $interviewRound)
    {
        if (auth()->user()->hasPermissionTo('department.delete')) {
            $interviewRound->delete();
            return response()->json([
                'success' => true,
                'message' => 'Interview Round deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
