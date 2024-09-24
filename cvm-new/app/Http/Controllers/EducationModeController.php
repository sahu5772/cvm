<?php

namespace App\Http\Controllers;

use App\Models\EducationMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EducationModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('education mode.view')) {
            if ($request->ajax()) {
                $data = EducationMode::where('is_active', 'Active')->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                        if (auth()->user()->hasPermissionTo('education mode.delete')) {
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteEducationMode('.$row->id.')" >Delete</a>';
                        }else{
                            $actionBtn = "You Have No Access";
                        }
                        $actionBtn .= '</div></div>';
                        return $actionBtn;
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('education.education-mode');
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:education_modes,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        EducationMode::create([
            'name' => request()->name,
            'company_id' => Auth::user()->company_id,
        ]);

        return redirect()->route('education-mode.index')->with('success','Mode created successfully');
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
        if (auth()->user()->hasPermissionTo('education mode.view')) {
            EducationMode::whereId($id)->update(['is_active' => 'Inactive']);

            return response()->json([
                'success' => true,
                'message' => 'Industry deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
