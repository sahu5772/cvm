<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('sectors.view')) {
            $industries = Industry::company()->get();
            if ($request->ajax()) {
                $data = Sector::with('industry')->active()->company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        if (auth()->user()->hasPermissionTo('sectors.delete')) {
                            $actionBtn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteSector('.$row->id.')" >Delete</a>';
                        }else{
                            $actionBtn = "You Have No Access";
                        }

                        return $actionBtn;
                    })
                    ->editColumn('industry', function($data) {
                        return ucfirst($data->industry->name);
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('setting.sector', compact('industries'));
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
            'name' => 'required||unique:sectors,name,NULL,id,company_id,' .auth()->user()->company_id,
            'industry_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        Sector::create([
            'name' => request()->name,
            'company_id' => Auth::user()->company_id,
            'industry_id' => request()->industry_id,
        ]);

        return redirect()->route('sector.index')->with('success','sector created successfully');
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
    public function destroy($sector)
    {

        Sector::where('id',$sector)->company()->update(['is_active' => 'Inactive']);
        return response()->json([
            'success' => true,
            'message' => 'Industry deleted successfully.',
        ]);
    }
}
