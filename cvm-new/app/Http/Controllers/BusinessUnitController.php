<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BusinessUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::get();
        $timezones = Timezone::get();
        if ($request->ajax()) {
            $data =  BusinessUnit::company()->active();
            return Datatables::of($data)
                ->addColumn('action', function($row){
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';
                        $actionBtn .='<a class="dropdown-item" onclick="viewUnit('.$row->id.')" data-id="'.$row->id.'">View</a>';
                        $actionBtn .='<a class="dropdown-item" href="'.route('business.edit', $row->id).'">Edit</a>';
                        $actionBtn .='<a class="dropdown-item deleteUnit" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                    return $actionBtn;
                })
                ->filter(function ($query) use ($request) {
                    if (!empty($request->get('is_active'))) {
                        $query->where('is_active', $request->get('is_active'));
                    }
                    if (!empty($request->get('country'))) {
                        $query->where('country_id', $request->get('country'));
                    }
                    if (!empty($request->get('timezone'))) {
                        $query->where('timezone_id', $request->get('timezone'));
                    }
                })
                ->editColumn('name', function($data){
                    return ucfirst($data->name);
                })
                ->editColumn('country', function($data){
                    return $data->country->name;
                })
                ->editColumn('status', function($data){
                    return $data->is_active;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('business.index', compact('countries', 'timezones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        $timezones = Timezone::get();
        return view('business.create', compact('countries', 'timezones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'pin_code' => 'required',
            'timezone_id' => 'required',
        ]);
        $input = request()->all();
        unset($input['_token']);

        BusinessUnit::create($input);

        return view('business.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data= BusinessUnit::with('country', 'timezone')->whereId($id)->first();
        $data = view('business.business-view',compact('data'))->render();
        return response()->json([
            'status'=>true,
            'data'=> $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $businessUnit = BusinessUnit::whereId($id)->first();
        $countries = Country::get();
        $states = State::get();
        $cities = City::get();
        $timezones = Timezone::get();
        return view('business.edit', compact('countries','states', 'cities', 'timezones', 'businessUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = request()->all();
        unset($input['_method']);
        unset($input['_token']);
        BusinessUnit::whereId($id)->update($input);

        return view('business.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessUnit  $businessUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BusinessUnit::whereId($id)->update(['is_Active' => 'Inactive']);

        return response()->json([
            'success' => true,
            'message' => 'Business Unit deleted successfully.',
        ]);
    }

    public function companyBusinessUnit(Request $request)
    {
        $countries = Country::get();
        $locations = BusinessUnit::with('country','state','city')->where('company_id',$request->id)->active()->get();
        $locationData = view('business.data', compact('locations','countries'))->render();
        return response()->json([
            'status' => true,
            'locations' => $locationData,
        ]);
    }

    public function companyLocationStore(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input,[
            'name' => 'required',
            'address' => 'required',
            'pin_code' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'phone_number' => 'required',
            'timezone_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }

        BusinessUnit::create($input);

        return response()->json([
            'success' => true,
            'location' => BusinessUnit::active()->company()->get(),
            'status' => 200,
            'message' => 'Business Unit Location created successfully.',
        ]);

    }

    public function companyLocationDelete(Request $request)
    {
        BusinessUnit::whereId($request->id)->update(['is_active' => 'Inactive']);

        $locations = BusinessUnit::with('country','state','city')->where('company_id', $request->company_id)->active()->get();
        $locationData = view('business.data', compact('locations'))->render();
        return response()->json([
            'success' => true,
            'message' => 'Business Unit deleted successfully.',
            'locations' => $locationData,
            'location' => BusinessUnit::select('id','name')->active()->company()->get(),
        ]);

    }
}
