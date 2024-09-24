<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('category.view')) {
            if ($request->ajax()) {
                $data = Category::active()->company()->get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '';

                        $actionBtn = '<div class="action--dropdown">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <img src="'. asset('images/icons/more.png').'" alt="" />
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';

                        if (auth()->user()->hasPermissionTo('category.update')) {
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="editCategory('.$row->id.')" >Edit</a>';
                        }

                        if (auth()->user()->hasPermissionTo('category.delete')) {
                            if ($actionBtn !== '') {
                                $actionBtn .= ' ';
                            }
                            $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteCategory('.$row->id.')" >Delete</a>';
                        }

                        if ($actionBtn === '') {
                            $actionBtn = 'You have no access';
                        } elseif (!auth()->user()->hasPermissionTo('category.update')) {
                            $actionBtn = 'No Access for edit'.$actionBtn;
                        } elseif (!auth()->user()->hasPermissionTo('category.delete')) {
                            $actionBtn .= 'No Access for delete';
                        }
                        $actionBtn .= '</div>
                        </div>';
                        return $actionBtn;


                    })
                    ->editColumn('name', function($data) {
                        return ucfirst($data->name);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('category.index');
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

        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        Category::create($request->only('name'));
        return redirect()->route('category.index')->with('success',trans('messages.category.create_category'));
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
        if (auth()->user()->hasPermissionTo('category.update')) {
            $category = Category::active()->company()->where('id',$id)->first();
            return response()->json(['data' => $category]);
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
    public function update(Request $request, $category_id)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required |unique:job_categories,name,'.$category_id,
        ]);
        if($validator->fails()){
         return response()->json($validator->errors()->tojson(),400);
        }
        try {
            unset($input['_method']);
            unset($input['category_id']);
            $data['updated_by'] = Auth::user()->id;
            $data = Category::find($category_id);
            if($data){
                $data =  $data->update($input);
            return response()->json([
                'success' => true,
                'message' =>trans('messages.category.update_category'),
            ]);

            }

        } catch (\Throwable $exception) {
            $response = $this->catchException($exception);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (auth()->user()->hasPermissionTo('category.delete')) {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
