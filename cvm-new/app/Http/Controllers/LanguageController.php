<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Language::get();
            return datatables()::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteLanguage('.$row->id.')" >Delete</a>';
                    return $actionBtn;
                })
                ->editColumn('name', function($data) {
                    return ucfirst($data->name);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('setting.language-setting');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        Language::create($request->only('name'));
        return redirect()->back()->with('success','Language created successfully');
    }

    public function destroy($id)
    {
        Language::where('id',$id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Language deleted successfully.',
        ]);

    }
}
