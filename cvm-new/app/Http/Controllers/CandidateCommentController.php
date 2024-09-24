<?php

namespace App\Http\Controllers;

use App\Models\CandidateComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CandidateCommentController extends Controller
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
        $input = $request->all();

        $validator = Validator::make($input,[
            'comment' => 'required',

        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }

        CandidateComment::create([
            'candidate_id' => $request->candidate_id,
            'company_id' => Auth::user()->company_id,
            'contact_through' => $request->input('contact_through'),
            'other_option' => isset($request->other_option)?$request->other_option:' ',
            'comment' => $request->comment,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Comment created successfully.',
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
        $comments = CandidateComment::where('candidate_id',$id)->where('company_id',Auth::user()->company_id)->get();
        $commentData = view('candidate.render-comment', compact('comments'))->render();
        return response()->json([
            'status' => true,
            'comments' => $commentData,
        ]);
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
    public function destroy($id)
    {
        $candidateId =  CandidateComment::where('id',$id)->where('company_id',Auth::user()->company_id)->first();
        CandidateComment::where('id',$id)->where('company_id',Auth::user()->company_id)->delete();

        $comments = CandidateComment::where('candidate_id',$candidateId['candidate_id'])->where('company_id',Auth::user()->company_id)->get();

        $commentData = view('candidate.render-comment', compact('comments'))->render();
        return response()->json([
            'status' => true,
            'message' => 'Candidate Comment deleted successfully.',
            'comments' => $commentData,
        ]);

    }
}
