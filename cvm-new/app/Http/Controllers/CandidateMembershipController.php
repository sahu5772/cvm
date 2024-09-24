<?php

namespace App\Http\Controllers;

use App\Models\CandidateMembership;
use App\Models\Membership;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CandidateMembership::with('membership')->where('candidate_id', $request->candidate_id)->get();
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if (auth()->user()->hasPermissionTo('membership details.update')) {
                        $actionBtn .='<a class="dropdown-item editMembership" href="javascript:void(0)" data-id="'.$row->id.'">Edit</a>';
                    }
                    if (auth()->user()->hasPermissionTo('membership details.view')) {
                        $actionBtn .='<a class="dropdown-item viewMembership" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                    }
                    if (auth()->user()->hasPermissionTo('membership details.delete')) {
                        $actionBtn .='<a class="dropdown-item deleteMembership" href="javascript:void(0)" data-id="'.$row->id.'">Delete</a>';
                    }
                    $actionBtn .= '</div></div>';
                    if (!auth()->user()->hasPermissionTo('membership details.update') && !auth()->user()->hasPermissionTo('membership details.delete')) {
                        $actionBtn .= 'No Access';
                    }
                    return $actionBtn;
                })
                ->editColumn('membership', function($data){
                    return $data->membership->name;
                })
                ->editColumn('number', function($data){
                    return $data->membership_number;
                })
                ->editColumn('type', function($data){
                    return $data->type;
                })
                ->editColumn('year', function($data){
                    return ($data->year_of_award) ? $data->year_of_award : 'NA';
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
        CandidateMembership::create(request()->all());
        return response()->json([
            'success' => true,
            'message' => 'Candidate Training create successfully.',
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
        $membership = CandidateMembership::whereId($id)->with('membership')->first();
        return response()->json([
            'membership' => $membership,
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
        $candidateMembership = CandidateMembership::whereId($id)->first();
        $membership = Membership::active()->company()->get();
        return response()->json([
            'candidateMembership' => $candidateMembership,
            'membership' => $membership,
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
        CandidateMembership::whereId($id)->update($input);
        return response()->json([
            'success' => true,
            'message' => 'Candidate Membership updated successfully.',
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
        CandidateMembership::whereId($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'membership deleted successfully.',
        ]);
    }
}
