<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('designation.view')) {
            if ($request->ajax()) {
                $data = Designation::active()->company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';

                                if (auth()->user()->hasPermissionTo('designation.update')) {
                                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="editDesignation(' . $row->id . ')" >Edit</a>';
                                }

                                if (auth()->user()->hasPermissionTo('designation.delete')) {
                                    if ($actionBtn !== '') {
                                        $actionBtn .= ' ';
                                    }
                                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteDesignation(' . $row->id . ')" >Delete</a>';
                                }

                                if ($actionBtn === '') {
                                    $actionBtn = 'You have no access';
                                } elseif (!auth()->user()->hasPermissionTo('designation.update')) {
                                    $actionBtn = 'No Access for edit'.$actionBtn;
                                } elseif (!auth()->user()->hasPermissionTo('designation.delete')) {
                                    $actionBtn .= 'No Access for delete';
                                }
                                $actionBtn .= '</div></div>';
                                return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('designation.index');
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
            'name' => 'required|unique:designations,name,NULL,id,company_id,' .auth()->user()->company_id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $current_date = Carbon::now()->format('Y-m-d H:i:s');

        $designation = Designation::create([
            'name' => $request->name,
            'company_id' => auth()->user()->company_id,
            'created_at' => $current_date,
            'created_by' => auth()->user()->id
        ]);

        return response()->json([
            'message' => 'Designation created successfully',
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
        if (auth()->user()->hasPermissionTo('designation.update')) {
            $designation= Designation::find($id);
            return response()->json(['data' => $designation]);
        }else{
            return redirect()->route('home');
        }
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $current_date = Carbon::now()->format('Y-m-d H:i:s');

        $designation = Designation::findOrFail($id);

        // Update currency properties based on the data in the request
        $designation->name = $request->input('name');
        $designation->company_id = Auth::user()->company_id;
        $designation->updated_at = $current_date;
        $designation->updated_by = auth()->user()->id;
        $designation->save();

        return response()->json(['message' => 'Designation updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        if (auth()->user()->hasPermissionTo('designation.delete')) {
            $designation->delete();
            return response()->json([
                'success' => true,
                'message' => 'Designation deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
