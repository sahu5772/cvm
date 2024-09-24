<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('currency.view')) {
            if ($request->ajax()) {
                $data = Currency::get();
                return datatables()::of($data)->addIndexColumn()
                    ->addColumn('action', function ($row) {
                            $actionBtn = '';
                            $actionBtn = '<div class="action--dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <img src="'. asset('images/icons/more.png').'" alt="" />
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">';
                            if (auth()->user()->hasPermissionTo('currency.update')) {
                                $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="editCurrency(' . $row->id . ')" >Edit</a>';
                            }

                            if (auth()->user()->hasPermissionTo('currency.delete')) {
                                if ($actionBtn !== '') {
                                    $actionBtn .= ' ';
                                }
                                $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item" onclick="deleteCurrency(' . $row->id . ')" >Delete</a>';
                            }

                            if ($actionBtn === '') {
                                $actionBtn = 'You have no access';
                            } elseif (!auth()->user()->hasPermissionTo('currency.update')) {
                                $actionBtn = 'No Access for edit'.$actionBtn;
                            } elseif (!auth()->user()->hasPermissionTo('currency.delete')) {
                                $actionBtn .= 'No Access for delete';
                            }

                        if($row->id == '1' || $row->id == '2'){
                            return 'you can not delete this Currency';
                        }
                        $actionBtn .= '</div></div>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('currency.index');
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
            'name' => 'required|string|max:255',
            'currency_symbol' => 'required|string|max:10',
            'currency_code' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $currency = Currency::create([
            'name' => $request->name,
            'currency_symbol' => $request->currency_symbol,
            'currency_code' => $request->currency_code,
            'created_at' => $currentDate
        ]);

        return response()->json([
            'message' => 'Currency created successfully',
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
        if (auth()->user()->hasPermissionTo('currency.update')) {
            $currency = Currency::find($id);
            return response()->json(['data' => $currency]);
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
            'currency_symbol' => 'required|string|max:10',
            'currency_code' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $currency = Currency::findOrFail($id);

        // Update currency properties based on the data in the request
        $currency->name = $request->input('name');
        $currency->currency_symbol = $request->input('currency_symbol');
        $currency->currency_code = $request->input('currency_code');
        $currency->updated_at = $currentDate;
        $currency->save();

        return response()->json(['message' => 'Currency updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        if (auth()->user()->hasPermissionTo('currency.delete')) {
            $currency->delete();
            return response()->json([
                'success' => true,
                'message' => 'Cureency deleted successfully.',
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}