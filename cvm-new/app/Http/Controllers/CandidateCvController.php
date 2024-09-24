<?php

namespace App\Http\Controllers;

use App\Models\CandidateCv;
use Illuminate\Http\Request;

class CandidateCvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($request->hasFile('file')) {
            $profileImage = $request->file('file');
            $source = time() . rand(11111, 99999) . '.' . $profileImage->getClientOriginalExtension();
            $destinationPath = public_path('images/candidate/cv');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
            $profileImage->move($destinationPath, $source);
            $input['file'] = $source;
            $input['candidate_id'] = $request->candidate_id;
        }

        $candidate = CandidateCv::create($input);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'CV Uploaded successfully.',
            'candidate' => $candidate,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CandidateCv  $candidateCv
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cv = CandidateCv::find($id);

        if (!$cv) {
            abort(404);
        }

        $filePath = public_path("images/candidate/cv/{$cv->file}");

        return response()->download($filePath, $cv->file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CandidateCv  $candidateCv
     * @return \Illuminate\Http\Response
     */
    public function edit(CandidateCv $candidateCv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CandidateCv  $candidateCv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CandidateCv $candidateCv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CandidateCv  $candidateCv
     * @return \Illuminate\Http\Response
     */
    public function destroy(CandidateCv $candidateCv)
    {
        //
    }
}
