<?php

namespace App\Http\Controllers;

use App\Models\CandidateAddress;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  CandidateAddress::with('country', 'state', 'city')->where('candidate_id', $request->candidate_id)->get();
            return Datatables::of($data)
                ->addColumn('action', function($row){
                                $actionBtn = '<div class="action--dropdown">
                                <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <img src="'. asset('images/icons/more.png').'" alt="" />
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">';
                                if (auth()->user()->hasPermissionTo('address details.update')) {
                                    $actionBtn .='<a class="dropdown-item editAddress" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                                }
                                if (auth()->user()->hasPermissionTo('address details.view')) {
                                    $actionBtn .='<a class="dropdown-item viewAddress" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                                }
                                if (auth()->user()->hasPermissionTo('address details.delete')) {
                                    $actionBtn .='<a class="dropdown-item deleteAddress" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                                }
                                $actionBtn .= '</div></div>';
                                if (!auth()->user()->hasPermissionTo('address details.update') && !auth()->user()->hasPermissionTo('address details.delete')) {
                                    $actionBtn .= 'No Access';
                                }

                    return $actionBtn;
                })
                ->editColumn('address', function($data){
                    return $data->address;
                })
                ->editColumn('country', function($data){
                    return $data->country->name;
                })
                ->editColumn('state', function($data){
                    return $data->state->name;
                })
                ->editColumn('city', function($data){
                    return $data->city->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $currentTab = 'pills-member';
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
        CandidateAddress::create(request()->all());
        return response()->json([
            'success' => true,
            'message' => 'Candidate Address create successfully.',
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
        $address = CandidateAddress::whereId($id)->with('country', 'state', 'city')->first();
        return response()->json([
            'address' => $address,
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
        $candidateAddress = CandidateAddress::whereId($id)->first();
        $countries = Country::get();
        $states = State::get();
        $cities = City::get();
        return response()->json([
            'candidateAddress' => $candidateAddress,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
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
        CandidateAddress::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Candidate Address updated successfully.',
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
        $data = CandidateAddress::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully.',
        ]);

    }
}
