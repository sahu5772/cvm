<?php

namespace App\Http\Controllers;

use App\Models\FundingAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FundingAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('funded agency.view')) {
            if ($request->ajax()) {
                $data = FundingAgency::active()->where('company_id',Auth::user()->company_id)->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';

                        $actionBtn .= '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                        if (auth()->user()->hasPermissionTo('funded agency.delete')) {
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteFundingAgency('.$row->id.')" >Delete</a>';
                        }else{

                            $actionBtn = "You Have No Access";
                        }
                        $actionBtn .= '</div>
                        </div>';
                        return $actionBtn;
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('fundingAgency.index');
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
            'name' => 'required|unique:funding_agencies,name',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        FundingAgency::create($request->only('name'));
        return redirect()->route('funding-agency.index')->with('success','Funding Agency created successfully');
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $FundingAgency_id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('funded agency.delete')) {
            FundingAgency::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'FundingAgency deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }

    }
}
