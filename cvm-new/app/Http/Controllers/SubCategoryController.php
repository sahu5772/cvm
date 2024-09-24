<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobSubCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data = SubCategory::active()->company()->with('category');
        if ($request->ajax()) {
            return datatables()
                ::of($data)
                ->addIndexColumn()
                ->editColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->editColumn('name', function ($data) {
                    return ucfirst($data->name);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn = '<div class="action--dropdown">
                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <img src="'. asset('images/icons/more.png').'" alt="" />
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">';

                        if (auth()->user()->hasPermissionTo('sub category.update')) {
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="editSubCategory(' .$row->id .')" >Edit</a>';
                        }

                        if (auth()->user()->hasPermissionTo('sub category.delete')) {
                            if ($actionBtn !== '') {
                                $actionBtn .= ' ';
                            }
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteSubCategory(' .$row->id .')" >Delete</a>';
                        }

                        if ($actionBtn === '') {
                            $actionBtn = 'You have no access';
                        } elseif (!auth()->user()->hasPermissionTo('sub category.update')) {
                            $actionBtn = 'No Access for edit'.$actionBtn;
                        } elseif (!auth()->user()->hasPermissionTo('sub category.delete')) {
                            $actionBtn .= 'No Access for delete';
                        }
                        $actionBtn .= '</div>
                        </div>';
                        return $actionBtn;

                })
                ->rawColumns(['action','category'])
                ->make(true);
        }
        $category = Category::get();
        return view('subcategory.index', compact('category'));
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
            'job_category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        SubCategory::create($request->all());
        return redirect()
            ->route('sub-category.index')
            ->with('success', 'SubCategory created successfully');
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
        if (auth()->user()->hasPermissionTo('sub category.update')) {
            $subcategory = SubCategory::active()->company()->with('category')->where('id',$id)->first();
            $category = Category::get();
            return response()->json(['data' => $subcategory,'category' => $category,'sub_cat_id'=>$subcategory->category?$subcategory->category->id:'0']);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required |unique:job_categories,name,' . $id,
            'job_category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson(), 400);
        }
        try {
            unset($input['_method']);
            $data['updated_by'] = Auth::user()->id;
            $data = SubCategory::find($id);
            if ($data) {
                $data = $data->update($input);
                return response()->json([
                    'success' => true,
                    'message' => 'Category update successfully.',
                ]);
            } else {
            }
        }catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('sub category.delete')) {
            SubCategory::where('id',$id)->update(['is_active' => 'Inactive']);
                return response()->json([
                    'success' => true,
                    'message' => 'SubCategory deleted successfully.',
                ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function getSubcategories($id)
{
    $subcategories = JobSubCategory::where('job_category_id', $id)->where('is_active', 1)->get();
    return response()->json($subcategories);
}
}
