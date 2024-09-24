@extends('layouts.app')

@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Schedule Interview</div>

        <div class="form_wrapper">
            <form action="{{ route('interview-schedule.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job<span class="reqText">*</span></label>
                            <select name="job_id">
                                <option value="">Select Job</option>
                                @foreach ($jobs as $job)
                                    <option value="{{$job->id}}">{{ ucfirst($job->title)}}</option>
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
                                    <option value="{{$user->id}}">{{ ucfirst($user->name)}}</option>
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
                                    <option value="{{$round->id}}">{{ ucfirst($round->name)}}</option>
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
                                <option value="Phone">Phone</option>
                                <option value="Video">Video</option>
                                <option value="In Person">In Person</option>
                            </select>
                            @error('interview_type')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Start On<span class="reqText">*</span></label>
                            <input type="date" name="interview_on" id="startOn" value="{{ old('start_on') }}" />
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
                            <input type="time" name="start_time" value="{{ old('start_time') }}" />
                            @if ($errors->has('start_time'))
                                <span class="text-danger text-left">{{ $errors->first('start_time') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-8">
                        <div class="input_grp">
                            <label for="">Comment for Interviewer</label>
                            <input type="text" name="comment_for_interviewer" value="{{ old('comment_for_interviewer') }}" />
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label>Notify Candidate</label>
                            <select name="notify_candidate" id="notify_candidate">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-8" id="comment">
                        <div class="input_grp">
                            <label for="">Comment for Candidate</label>
                            <input type="text" name="comment_for_candidate" value="{{ old('comment_for_interviewer') }}" />
                        </div>
                        <!-- ./input_grp -->
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

        $('#startOn').on('blur', function () {
            validateStartOn();
        });

        function validateStartOn() {
            var startDate = $('#startOn').val();

            if (startDate) {
                var startDateObj = new Date(startDate);
                var currentDate = new Date();

                if (startDateObj < currentDate) {
                    $('#startError').text('Please select a start date greater than or equal to the current date.');
                    $('#startOn').val('');
                } else {
                    $('#startError').text('');
                }
            }
        }

        $('#notify_candidate').on('change', function () {
            let value = $('#notify_candidate').val();

            (value === 'No') ? $('#comment').hide() : $('#comment').show();
        });
    </script>
@endpush