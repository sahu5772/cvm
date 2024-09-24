@extends('layouts.app')

@section('content')
<main class="employee_wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="title">Interview Schedule List</div>
                @can('employee.add')
                <a href="{{ route('interview-schedule.create')}}" class="btn_style">
                    <img src="{{ asset('images/icons/icons8-manage-48.png')}}" alt="">
                    Add Interview
                </a>
                @endcan
            </div>
            <!-- ./heading -->
            <div class="row">
                <div class="col-3 candidate_filter">
                    <div class="general_filter">
                        <div class="first-filter-header">
                            <h3 class="general-filters-cont">Filters
                                <div class="notification">
                                    <a href="{{route('job.index')}}">
                                        <img src="{{asset('/images/icons/undo-arrow.png')}}" width="20" alt="">
                                    </a>
                                </div>
                            </h3>
                        </div>
                        <div class="input_grp">
                            <label for="">Start Date</label>
                            <div class="input-group">
                                <input type="date" name="interview_on" id="date" value=""
                                    class="form-control date" placeholder="Min Experience">
                            </div>
                            {{-- <div id="exp_error" style="color: red;"></div> --}}
                        </div>
                        <div class="form_wrapper mt-5">
                            <div class="input_grp">
                                <label for="">Status</label>
                                <select name="status" id="status">
                                    <option value="" selected>select</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Hired">Hired</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Canceled">Canceled</option>
                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Interviewer</label>
                                <select name="interviewer_id" id="interviewer">
                                    <option value="">All Interviewers</option>
                                    @foreach ($interviewers as $interviewer)
                                    <option value="{{$interviewer->id}}">{{$interviewer->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Candidate</label>
                                <select name="candidate_id" id="candidate">
                                    <option value="">All Candidate</option>
                                    @foreach ($candidates as $candidate)
                                    <option value="{{$candidate->id}}">{{$candidate->first_name}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="table__wrapper">
                        <table class="table interviewDatatable  w-100">
                            <thead>
                                <tr>
                                    <th scope="col" width="15%">Candidate Name</th>
                                    <th scope="col" width="16%">interviewer Name</th>
                                    <th scope="col" width="20%">Scheduled Date and Time</th>
                                    <th scope="col" width="20%">Interview Round</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- ./table__wrapper -->
                </div>
            </div>
            <!-- ./row -->
        </div>
        <!-- ./container -->
    </section>
</main>
<!-- view Modal -->
<div class="modal fade" id="viewProfessionalModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body comment-model">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    Interview Schedule Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Job Title</span>
                                        <p id="job"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Candidate Name</span>
                                        <p id="candidateName"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Interviewer Name</span>
                                        <p id="interviewerName"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Interview Round</span>
                                        <p id="interviewRound"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Interview Type</span>
                                        <p id="interviewType"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Interview On</span>
                                        <p id="interviewOn"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Start Time</span>
                                        <p id="startTime"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Comment For Interviewer</span>
                                        <p id="commentForInterviewer"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Notify Candidate</span>
                                        <p id="notifyCandidate"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Comment For Candidate</span>
                                        <p id="commentForCandidate"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- ./row -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
{{-- @include('users.edit') --}}
@endsection
@push('scripts')

<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.interviewDatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('interview-schedule.index') }}",
            data: function(d) {
                    d.interview_on = $('#date').val(),
                    d.status = $('#status').val(),
                    d.interviewer_id = $('#interviewer').val(),
                    d.candidate_id = $('#candidate').val()
                }
            },
            columns: [
                {
                    data: 'candidate',
                    name: 'candidate',
                },
                {
                    data: 'interviewer',
                    name: 'interviewer',
                },
                {
                    data: 'scheduleDateTime',
                    name: 'scheduleDateTime',
                },
                {
                    data: 'interview_round.name',
                    name: 'interviewRound',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'action',
                    name: 'action',
                },
            ]

    });
        $('#date').on('change', function() {
            table.draw();
        });
        $('#status').on('change', function() {
            table.draw();
        });
        $('#interviewer').on('change', function() {
            table.draw();
        });
        $('#candidate').on('change', function() {
            table.draw();
        });
});

$('body').on('click', '.deleteInterview', function () {

var id = $(this).data("id");
var url = '{{ route("interview-schedule.destroy", ":id") }}';
    url = url.replace(':id', id);

Swal.fire({
    title             : "Delete",
    text              : "Do you realy want to delete!",
    icon              : "warning",
    showCancelButton  : true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor : "#d33",
    confirmButtonText : "Yes, Delete this interview schedule!"
}).then((result) => {
    if (result.value) {
        $.ajax({
            url    : url,
            type   : "delete",
            success: function(data) {
                    if (data.success) {
                    $('.interviewDatatable').DataTable().ajax.reload();
                    Swal.fire('Deleted!','Your file has been deleted.',
                    'success')
                    }
            }
        })
    }
})
});

$('body').on('click', '.viewInterview', function () {

var id = $(this).data("id");
var url = '{{ route("interview-schedule.show", ":id") }}';
url = url.replace(':id', id);

$.ajax({
    url    : url,
    type   : "get",
    success: function(response) {
    console.log(response);
    var data = response.data;

    $("#viewProfessionalModel").modal("show");
    document.getElementById('job').innerText = data.job.title;
    document.getElementById('candidateName').innerText = data.candidate.first_name;
    document.getElementById('interviewerName').innerText = (data.interviewer.name) ? data.interviewer.name : '-';
    document.getElementById('interviewRound').innerText = data.interview_round.name;
    document.getElementById('interviewType').innerText = data.interview_type;
    document.getElementById('interviewOn').innerText = data.interview_on;
    document.getElementById('startTime').innerText = data.start_time;
    document.getElementById('commentForInterviewer').innerText = data.comment_for_interviewer;
    document.getElementById('notifyCandidate').innerText = data.notify_candidate;
    document.getElementById('commentForCandidate').innerText = (data.comment_for_candidate)?data.comment_for_candidate:'-';
}

})
});
</script>
@endpush