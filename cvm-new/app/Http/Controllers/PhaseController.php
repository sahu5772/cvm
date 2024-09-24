<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Phase;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('phase.view')) {
            $industries = Industry::company()->get();

            if ($request->ajax()) {
                $data = Phase::with('industry', 'sector')->active()->company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        if (auth()->user()->hasPermissionTo('phase.delete')) {
                            $actionBtn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deletePhase('.$row->id.')" >Delete</a>';
                        }else{
                            $actionBtn = "You Have No Access";
                        }
                        return $actionBtn;
                    })
                    ->editColumn('industry', function($data) {
                        return ucfirst($data->industry->name);
                    })
                    ->editColumn('sector', function($data) {
                        return ucfirst($data->sector->name);
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('setting.phase', compact('industries'));
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
            'name' => 'required||unique:phases,name,NULL,id,company_id,' .auth()->user()->company_id,
            'industry_id' => 'required',
            'sector_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        Phase::create([
            'name' => request()->name,
            'company_id' => Auth::user()->company_id,
            'industry_id' => request()->industry_id,
            'sector_id' => request()->sector_id,
        ]);

        return redirect()->route('phase.index')->with('success','phase created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phase $phase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phase  $phase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('phase.view')) {
            Phase::whereId($id)->update(['is_active' => 'Inactive']);
            return response()->json([
                'success' => true,
                'message' => 'Phase deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function sectorList() {
        $data['sector'] = Sector::where('industry_id', request()->id)->active()->get();
        return response()->json($data);
    }
}
