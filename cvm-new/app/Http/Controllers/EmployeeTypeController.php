<?php

namespace App\Http\Controllers;

use App\Models\EmployerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('employee type.view')) {
            if ($request->ajax()) {
                $data = EmployerType::active()->company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                            if (auth()->user()->hasPermissionTo('employee type.delete')) {
                                $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteEmployeType('.$row->id.')">Delete</a>';
                            }else{
                                $actionBtn .= "You Have No Access";
                            }
                            $actionBtn .= '</div></div>';
                            return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('setting.employee-type');
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
            'name' => 'required||unique:employer_types,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        EmployerType::create([
            'name' => request()->name,
            'company_id' => Auth::user()->company_id,
        ]);

        return redirect()->route('employee-type.index')->with('success','Employee Type created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployerType  $employerType
     * @return \Illuminate\Http\Response
     */
    public function show(EmployerType $employerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployerType  $employerType
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployerType $employerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployerType  $employerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployerType $employerType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployerType  $employerType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('employee type.delete')) {
            EmployerType::where('id',$id)->update(['is_active'=>'Inactive']);
            return response()->json([
                'success' => true,
                'message' => 'EmployerType deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
