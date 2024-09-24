<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyLogo;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $company = Company::with('getCompanySetting','getCompanyLogo')->where('id', Auth::user()->company_id)->first();
        return view('setting.company-setting', compact('company'));
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
        //
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
        $validator = Validator::make($request->all(), [
            'prefix' => 'required|string',
            'email' => 'required',
            'phone_number' => 'required',
            'website' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $data = request()->all();
        unset($data['_token'],$data['_method']);
        $company = Company::find(request()->company_id);
        $company->update($data);
        $companyLogo = CompanyLogo::where('company_id', request()->company_id)->first();
        if(isset($companyLogo)){
            $imagePath = public_path('company/logo/' . $companyLogo->logo);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $source = time() . rand(11111, 99999) . '.' . $logo->getClientOriginalExtension();
            $destinationPath = public_path('./images/company');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $logo->move($destinationPath, $source);
            $request['logo'] = $source;

            CompanyLogo::updateOrCreate(['company_id'=>request()->company_id],['logo' => $source]);
        }

        CompanySetting::updateOrCreate(['company_id'=>request()->company_id],[
            'prefix' => $request->prefix,
            'separator' => $request->separator,
        ]);

       $logo =   CompanyLogo::where('company_id', request()->company_id)->pluck('logo')->first();
        return response()->json([
            'message' => 'company Setting updated successfully',
           'logo' => url('/images/company/'.$logo),
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
        //
    }
}
