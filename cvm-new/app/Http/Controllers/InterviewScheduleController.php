<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\InterviewRound;
use App\Models\InterviewSchedule;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterviewScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasPermissionTo('employee.view')) {
            if ($request->ajax()) {
                $data = InterviewSchedule::company()->with('candidate', 'job', 'interviewer', 'interviewRound');
                return Datatables::of($data)
                    ->addColumn('scheduleDateTime', function ($row) {
                        $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $row->interview_on . ' ' . $row->start_time)
                            ->format('d F, Y, h:i A');
                        return $dateTime;
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        $actionBtn = '<div class="action--dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <img src="'. asset('images/icons/more.png').'" alt="" />
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">';
                        if (!auth()->user()->hasPermissionTo('employee.update') && !auth()->user()->hasPermissionTo('employee.delete')) {
                            $actionBtn = '';
                            $actionBtn .= 'No Access';
                        } else {
                            if (auth()->user()->hasPermissionTo('employee.update')) {
                                $actionBtn .= '<a href="' . route('interview-schedule.edit', $row->id) .'" class="dropdown-item" data-id="'.$row->id.'">Edit</a>';
                            }
                            $actionBtn .='<a class="dropdown-item viewInterview" href="javascript:void(0)" data-id="'.$row->id.'">View</a>';
                            if (auth()->user()->hasPermissionTo('employee.delete')) {
                                $actionBtn .= '<a href="javascript:void(0)" class="dropdown-item deleteInterview" data-id="'.$row->id.'" >Delete</a>';
                            }
                            $actionBtn .= '</div></div>';
                        }
                        return $actionBtn;
                    })
                        ->addColumn('candidate', function (InterviewSchedule $candidate) {
                            return $candidate->candidate?$candidate->candidate->first_name:'NA';
                        })
                        ->addColumn('interviewer', function (InterviewSchedule $interviewer) {
                            return $interviewer->interviewer?$interviewer->interviewer->name:'NA';
                        })
                        ->addColumn('interviewRound', function (InterviewSchedule $interviewRound) {
                            return $interviewRound->interviewRound?$interviewRound->interviewRound->name:'NA';
                        })
                        ->filter(function ($query) use ($request) {
                            if (!empty($request->get('interview_on'))) {
                                $query->where('interview_on', $request->get('interview_on'));
                            }
                            if (!empty($request->get('status'))) {
                                $query->where('status', $request->get('status'));
                            }
                            if (!empty($request->get('interviewer_id'))) {
                                $query->where('interviewer_id', $request->get('interviewer_id'));
                            }
                            if (!empty($request->get('candidate_id'))) {
                                $query->where('candidate_id', $request->get('candidate_id'));
                            }
                        })

                        ->rawColumns(['action',])
                        ->make(true);
                }
                $candidates = Candidate::where('company_id', Auth::user()->company_id)->get();
                $interviewers = User::where('company_id', Auth::user()->company_id)->get();
                return view('interview.index',compact('candidates', 'interviewers'));
        }else
        {
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
        $candidateData = '';
        $candidates = Candidate::active()->company()->get();
        $jobs = Job::active()->company()->get();
        $interviewers = User::active()->company()->get();
        $rounds = InterviewRound::company()->get();
        return view('interview.create', compact('candidateData', 'candidates', 'jobs', 'interviewers', 'rounds'));
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
            'interview_type' => 'required|string',
            'interview_on' => 'required',
            'job_id' => 'required|numeric',
            'candidate_id' => 'required|numeric',
            'interviewer_id' => 'required|numeric',
            'interview_round_id' => 'required|numeric',
            'start_time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        InterviewSchedule::create(request()->all());

        return redirect()->route('interview-schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidateData = InterviewSchedule::company()->with('candidate','job','interviewer','interviewRound')->find($id);
        return response()->json([
            'data' => $candidateData,
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
        $candidateData = InterviewSchedule::company()->with('candidate','job','interviewer','interviewRound')->find($id);
        $candidates = Candidate::active()->company()->get();
        $jobs = Job::active()->company()->get();
        $interviewers = User::active()->company()->get();
        $rounds = InterviewRound::company()->get();
        return view('interview.edit', compact('candidateData', 'candidates', 'jobs', 'interviewers', 'rounds'));
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
            'interview_type' => 'required|string',
            'interview_on' => 'required',
            'job_id' => 'required|numeric',
            'candidate_id' => 'required|numeric',
            'interviewer_id' => 'required|numeric',
            'interview_round_id' => 'required|numeric',
            'start_time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $interviewSchedule = InterviewSchedule::findOrFail($id);

        $interviewSchedule->update(request()->all());

        return redirect()->route('interview-schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InterviewSchedule  $interviewSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterviewSchedule $interviewSchedule)
    {
        $interviewSchedule->delete();
            return response()->json([
                'success' => true,
                'message' => 'Interview Schedule deleted successfully.',
            ]);
    }

    public function schedule($id)
    {
        $candidateData = Candidate::find($id);
        $candidates = Candidate::active()->company()->get();
        $jobs = Job::active()->company()->get();
        $interviewers = User::active()->company()->get();
        $rounds = InterviewRound::company()->get();
        return view('interview.create', compact('candidateData', 'candidates', 'jobs', 'interviewers', 'rounds'));
    }
}
