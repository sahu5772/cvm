@extends('layouts.app')

@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Edit Interview Schedule</div>

        <div class="form_wrapper">
            <form action="{{ route('interview-schedule.update', $candidateData->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job<span class="reqText">*</span></label>
                            <select name="job_id">
                                <option value="">Select Job</option>
                                @foreach ($jobs as $job)
                                    <option value="{{$job->id}}" {{($job->id == $candidateData->job_id)?'selected':''}}>{{ ucfirst($job->title)}}</option>
                                @endforeach
                            </select>
                            @error('job_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Candidate<span class="reqText">*</span></label>
                            <select name="candidate_id">
                                <option value="">Select Candidate</option>
                                @foreach ($candidates as $candidate)
                                    <option value="{{$candidate->id}}" @if (!empty($candidateData))
                                        {{($candidate->id == $candidateData->id) ? 'selected' : ''}}
                                    @endif>{{ ucfirst($candidate->first_name . ' '. $candidate->last_name)}}</option>
                                @endforeach
                            </select>
                            @error('candidate_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Interviewer<span class="reqText">*</span></label>
                            <select name="interviewer_id">
                                <option value="">Select Interviewer</option>
                                @foreach ($interviewers as $user)
                                    <option value="{{$user->id}}" @if (!empty($candidateData))
                                        {{($user->id == $candidateData->interviewer_id) ? 'selected' : ''}}
                                    @endif>{{ ucfirst($user->name)}}</option>
                                @endforeach
                            </select>
                            @error('interviewer_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Interview Round<span class="reqText">*</span></label>
                            <select name="interview_round_id">
                                <option value="">Select Interview Round</option>
                                @foreach ($rounds as $round)
                                    <option value="{{$round->id}}" @if (!empty($candidateData))
                                        {{($round->id == $candidateData->interview_round_id) ? 'selected' : ''}}
                                    @endif>{{ ucfirst($round->name)}}</option>
                                @endforeach
                            </select>
                            @error('interview_round_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Interview Type<span class="reqText">*</span></label>
                            <select name="interview_type">
                                <option value="">Select Interview Type</option>
                                <option value="Phone" {{('Phone' == $candidateData->interview_type)?'selected':''}}>Phone</option>
                                <option value="Video" {{('Video' == $candidateData->interview_type)?'selected':''}}>Video</option>
                                <option value="In Person" {{('In Person' == $candidateData->interview_type)?'selected':''}}>In Person</option>
                            </select>
                            @error('interview_type')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Start On<span class="reqText">*</span></label>
                            <input type="date" name="interview_on" id="startOn" value="{{ $candidateData->interview_on }}" />
                            @if ($errors->has('interview_on'))
                                <span class="text-danger text-left">{{ $errors->first('interview_on') }}</span>
                            @endif
                            <div id="startError" style="color: red;"></div>
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Start Time<span class="reqText">*</span></label>
                            <input type="time" name="start_time" value="{{ $candidateData->start_time }}" />
                            @if ($errors->has('start_time'))
                                <span class="text-danger text-left">{{ $errors->first('start_time') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-8">
                        <div class="input_grp">
                            <label for="">Comment for Interviewer</label>
                            <input type="text" name="comment_for_interviewer" value="{{ $candidateData->comment_for_interviewer }}" />
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label>Notify Candidate</label>
                            <select name="notify_candidate" id="notify_candidate">
                                <option value="Yes" {{('Yes' == $candidateData->notify_candidate)?'selected':''}}>Yes</option>
                                <option value="No" {{('No' == $candidateData->notify_candidate)?'selected':''}}>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8" id="comment">
                        <div class="input_grp">
                            <label for="">Comment for Candidate</label>
                            <input type="text" name="comment_for_candidate" value="{{ $candidateData->comment_for_candidate }}" />
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Status<span class="reqText">*</span></label>
                            <select name="status">
                                <option value="">Select Interview Status</option>
                                <option value="Pending" {{('Pending' == $candidateData->status)?'selected':''}}>Pending</option>
                                <option value="Hired" {{('Hired' == $candidateData->status)?'selected':''}}>Hired</option>
                                <option value="Rejected" {{('Rejected' == $candidateData->status)?'selected':''}}>Rejected</option>
                                <option value="Completed" {{('Completed' == $candidateData->status)?'selected':''}}>Completed</option>
                                <option value="Canceled" {{('Canceled' == $candidateData->status)?'selected':''}}>Canceled</option>
                            </select>
                            @error('status')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- ./row -->

                <div class="button_flex">
                    <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                        Reset
                    </button>
                    <button type="submit" class="btn_style">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- container -->
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        if ($("#notify_candidate").val() === "No") {
            $("#comment").hide();
        }

        $("#notify_candidate").change(function () {
            if ($(this).val() === "No") {
                $("#comment").hide();
            } else {
                $("#comment").show();
            }
        });
    });
</script>

@endpush