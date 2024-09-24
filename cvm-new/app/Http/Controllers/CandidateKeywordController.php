<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Sector;
use App\Models\Keyword;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\KeywordRecord;
use App\Models\CandidateKeyword;
use Illuminate\Support\Facades\Validator;

class CandidateKeywordController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sector::where('industry_id', $request->industry_id)->get();
            $keywords = CandidateKeyword::where('candidate_id', $request->candidate_id)->first();
            $sectors = view('candidate.render-sector', compact('data', 'keywords'))->render();
            return response()->json([
                'status' => true,
                'sectors' => $sectors,
            ]);
        }
    }
    public function getCandidatePhase(Request $request)
    {
        if ($request->ajax()) {
            $data = Phase::where('sector_id', $request->sector_id)->get();
            $phases = view('candidate.render-phase', compact('data'))->render();
            return response()->json([
                'status' => true,
                'phases' => $phases,
            ]);
        }
    }
    public function getCandidateKeyword(Request $request)
    {
        if ($request->ajax()) {
            $data = Keyword::where('phase_id', $request->phase_id)->get();
            $keywords = view('candidate.render-keyword', compact('data'))->render();
            return response()->json([
                'status' => true,
                'keywords' => $keywords,
            ]);
        }
    }
    public function keywordStore(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'keyword_id' => 'required',
            'candidate_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson(), 400);
        }
        $data = [];
        if($request->industry_id){
            $data['industry_id'] = $request->industry_id;
        }
        if($request->candidate_id){
            $data['candidate_id'] = $request->candidate_id;
        }
        if($request->sector_id){
            $data['sector_id'] = $request->sector_id;
        }
        if($request->sector_id){
            $data['sector_id'] = $request->sector_id;
        }
        if($request->phase_id){
            $data['phase_id'] = $request->phase_id;
        }

        CandidateKeyword::updateOrCreate(['candidate_id' => $request->candidate_id],$data);

        if($request->keyword_id){
        $value = Candidate::where('id',$request->candidate_id)->first();
        $value->getKeywordRecord()->sync($request->keyword_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Keyword save successfully.',
        ]);
    }
}
