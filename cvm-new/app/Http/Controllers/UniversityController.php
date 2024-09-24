<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('university.view')) {
            if ($request->ajax()) {
                $data = University::where('is_active', 'Active')->where('company_id', Auth::user()->company_id)->with('country','state','city')->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                        if (auth()->user()->hasPermissionTo('university.delete')) {
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteUniversity('.$row->id.')" >Delete</a>';
                        }else{
                            $actionBtn = "You Have No Access";
                        }
                        $actionBtn .= '</div></div>';
                        return $actionBtn;
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->editColumn('country', function ($data) {
                        return $data->country->name;
                    })
                    ->editColumn('state', function ($data) {
                        return $data->state->name;
                    })
                    ->editColumn('city', function ($data) {
                        return $data->city->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            $country = Country::get();
            return view('education.university',compact('country'));
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
        $input = $request->all();
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:universities,name,NULL,id,company_id,' .auth()->user()->company_id,
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $input['company_id'] = Auth::user()->company_id;
        $input['created_by'] = Auth::user()->id;
        University::create($input);

        return redirect()->route('university.index')->with('success','university created successfully');
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
        if (auth()->user()->hasPermissionTo('university.view')) {
            University::whereId($id)->update(['is_active' => 'Inactive']);

            return response()->json([
                'success' => true,
                'message' => 'university deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
