@extends('layouts.app')
@section('content')
<main class="jobPost__wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="title">Job Post List</div>
                @can('job post.add')
                <a href="{{ route('job.create') }}" class="btn_style">
                    <img src="{{asset('/')}}images/icons/icons8-manage-48.png" alt="">
                    Add Job Post
                </a>
                @endcan
            </div>

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
                        <div class="form_wrapper mt-5">
                            <div class="input_grp">
                                <label for="">Status</label>
                                <select name="active" id="active">
                                    <option value="" selected>Please Select Status</option>
                                    <option value="">Both</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Close</option>
                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Category</label>
                                <select name="category" id="category">
                                    <option value="" selected>Please Select Job Category</option>
                                    <option value="">All Category</option>
                                    @foreach ($data as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Location</label>
                                <select name="location" id="location">
                                    <option value="">Please Select Location</option>
                                    <option value="">All Location</option>
                                    @foreach ($locations as $location)
                                    <option value="{{$location->id}}">{{$location->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Department</label>
                                <select name="department_id" id="department_id">
                                    <option value="">Please Select Department</option>
                                    <option value="">All Department</option>
                                    @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="input_grp">
                                <label for="">Start Date</label>
                                <div class="input-group">
                                    <input type="date" name="start_date" id="start_date" value=""
                                        class="form-control start_date" placeholder="Min Experience">
                                </div>
                                {{-- <div id="exp_error" style="color: red;"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9 mt-5">
                    <div class="table__wrapper">
                        <table class="table job_datatable display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th scope="col">Title</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Recruiter</th>
                                    <th scope="col">Job Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col" width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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
<div class="modal fade" id="viewJobModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Job details</h5>
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
            <div id="jobDetail"></div>
        </div>
    </div>
</div>

<!-- details via email -->
<div class="modal editModel fade" id="editModalDetailJob" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="jobDetailEmail">

        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.job_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('job.index') }}",
                data: function(d) {
                    d.category = $('#category').val(),
                    d.active = $('#active').val(),
                    d.location = $('#location').val(),
                    d.department_id = $('#department_id').val(),
                    d.start_date = $('#start_date').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex'
                // },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                },
                {
                    data: 'recruiter',
                    name: 'recruiter'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
        $('#location').on('change', function() {
            table.draw();
        });
        $('#category').on('change', function() {
            table.draw();
        });
        $('#active').on('change', function() {
            table.draw();
        });
        $('#department_id').on('change', function() {
            table.draw();
        });
        $('#start_date').on('change', function() {
            table.draw();
        });
    });

    function deleteJob(e) {
        var url = '{{ route("job.destroy", ":id") }}';
        url = url.replace(':id', e);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: "Delete",
            text: "Do you realy want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete this item!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "delete",
                    success: function(data) {
                        if (data.success) {
                            $('.job_datatable').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Your file has been deleted.',
                                'success')
                        }
                    }
                })
            }
        })
    }

    function changeJobStatus(jobId) {
        var newStatus = $('#status-select-' + jobId).val(); // Get the selected status

        var url = '{{ route("job.status-change", ["id" => ":id", "newStatus" => ":newStatus"]) }}';
        url = url.replace(':id', jobId);
        url = url.replace(':newStatus', newStatus);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Swal.fire({
            title: "Status Change",
            text: "Do you really want to " + newStatus + " this job?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, " + newStatus + " this Job!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        newStatus: newStatus
                    }, // Include newStatus in the request data
                    success: function(data) {
                        if (data.success) {
                            $('.job_datatable').DataTable().ajax.reload();
                            Swal.fire('Changes!', 'Your Job has been ' + newStatus + 'd.',
                                'success')
                        }
                    }
                })
            }
        })
    }

    function viewJob(e) {
        var url = '{{ route("job.show", ":id") }}';
        url = url.replace(':id', e);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: "get",
            success: function(response) {
                $('#jobDetail').html(response.data);
                $("#viewJobModel").modal("show");
            }
        })
    }

    function shareDetailEmail(id) {
        var url = '{{ route('share-detail-modal-job', ':id') }}';
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "get",
            data: {
                candidate_id: id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                $('#jobDetailEmail').html(response.data);
                $('#editModalDetailJob').modal("show");
            }
        });
    }

    function sendDetailJob(id){
        var job_id = id;
        var val = $('.email').val();
        $.ajax({
                url: "{{ route('share-detail-job') }}",
                type: "POST",
                data: {
                    job_id: job_id,
                    email: val,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
            });
    }

</script>
@endpush
@endsection