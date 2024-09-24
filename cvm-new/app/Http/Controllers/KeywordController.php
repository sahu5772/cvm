<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Phase;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeywordController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('keyword.view')) {
            if ($request->ajax()) {
                $data = Keyword::with('phase')->active()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('phase', function ($data) {
                        return $data->phase->name;
                    })
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        if (auth()->user()->hasPermissionTo('keyword.delete')) {
                            $actionBtn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteValue('.$row->id.')" >Delete</a>';
                        }else{
                            $actionBtn = "You Have No Access";
                        }

                        return $actionBtn;
                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action','phase'])
                    ->make(true);
            }

            $phases = Phase::get();
            return view('setting.keyword',compact('phases'));
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
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        Keyword::create([
            'keyword' => request()->name,
            'phase_id' => request()->phase_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keyword Create successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keyword  $Keyword
     * @return \Illuminate\Http\Response
     */
    public function show(Keyword $Keyword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keyword  $Keyword
     * @return \Illuminate\Http\Response
     */
    public function edit(Keyword $Keyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keyword  $Keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keyword $Keyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keyword  $Keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('keyword.view')) {
            Keyword::where('id',$id)->update(['is_active'=>'Inactive']);
            return response()->json([
                'success' => true,
                'message' => 'Keyword deleted successfully.',

            ]);
        }else{
            return redirect()->route('home');
        }
    }
}