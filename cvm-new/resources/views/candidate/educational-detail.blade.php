<div class="tab-pane fade" id="pills-educational" role="tabpanel" aria-labelledby="pills-educational-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="viewCandidate_download">

                </div>

                <div class="d-flex align-items-center">
                    <div class="title"> {{ __('messages.candidate.educational_details')}}</div>
                    @if (auth()->user()->hasPermissionTo('educational details.add'))
                    <a class="btn_style drawerMenu-education">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        {{ __('messages.add')}} {{ __('messages.candidate.educational_details')}}
                    </a>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="table__wrapper">
                    <table class="table educationDatatable  w-100">
                        <thead>
                            <tr>
                                <th scope="col" width="15%">Qualification</th>
                                <th scope="col" width="5%">From</th>
                                <th scope="col" width="5%">To</th>
                                <th scope="col" width="10%">Percentage</th>
                                <th scope="col" width="10%">Mode</th>
                                <th scope="col" width="10%">Specialization</th>
                                <th scope="col" width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- ./table__wrapper -->
            </div>
            <!-- ./container -->
        </section>
    </main>
</div>

<!-- view Modal -->
<div class="modal fade" id="viewEducationModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    Education Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Qualification</span>
                                        <p id="qualification"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Subject</span>
                                        <p id="subject"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Specialization</span>
                                        <p id="specialization"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Institue/University</span>
                                        <p id="university"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>From Date</span>
                                        <p id="fromDate"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>To Date</span>
                                        <p id="toDate"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Percentage</span>
                                        <p id="percentage"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Mode of study</span>
                                        <p id="modeOfStudy"></p>
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

<!-- edit Modal -->
<div class="modal fade" id="editEducationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit details</h5>
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
            <div class="modal-body">
                <form id="editEducationForm" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="education_id" id="education_id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Qualification</label>
                                <select class="form-control" name="educational_level_id" id="educational_level_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Subject <span class="reqText">*</span></label>
                                <select class="form-control" name="subject_id" id="subject_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Specialization<span class="reqText">*</span></label>
                                <input type="text" name="specialization" id="specialization" value="" placeholder="Enter Specialization">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Institue/University<span class="reqText">*</span></label>
                                <select class="form-control" name="university_id" id="university_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">From Date<span class="reqText">*</span></label>
                                <input type="text" name="from_year" id="from_year" value="" placeholder="type here..." class="datepicker">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">To Date<span class="reqText">*</span></label>
                                <input type="text" name="to_year" id="to_year" value="" placeholder="type here..." class="datepicker1">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Percentage<span class="reqText">*</span></label>
                                <input type="number" name="percentage" id="percentage" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Mode Of Study<span class="reqText">*</span></label>
                                <select class="form-control" name="education_mode_id" id="education_mode_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn_style">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

    $(".datepicker").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: true
    });

    $(".datepicker1").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.educationDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('candidate-education.index') }}",
                data: function(d) {
                    d.candidate_id = '{{ $candidate->id}}'
                }
            },
            columns: [{
                    data: 'qualification',
                    name: 'qualification'
                },
                {
                    data: 'from',
                    name: 'from'
                },
                {
                    data: 'to',
                    name: 'to'
                },
                {
                    data: 'percentage',
                    name: 'percentage'
                },
                {
                    data: 'mode',
                    name: 'mode'
                },
                {
                    data: 'specialization',
                    name: 'specialization'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

    $('body').on('click', '.deleteEducation', function() {

        var id = $(this).data("id");
        var url = '{{ route("candidate-education.destroy", ":id") }}';
        url = url.replace(':id', id);

        Swal.fire({
            title: "Delete",
            text: "Do you realy want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete this education!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "delete",
                    success: function(data) {
                        if (data.success) {
                            $('.educationDatatable').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Your file has been deleted.',
                                'success')
                        }
                        }
                    })
                }
            })
    });

    $('body').on('click', '.editEducation', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-education.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#education_id').val(data.education.id);
                $('#from_year').val(data.education.from_year);
                $('#to_year').val(data.education.to_year);
                $('#specialization').val(data.education.specialization);
                $('#percentage').val(data.education.percentage);

                $('#educational_level_id').val(data.education.educational_level_id);
                var len = 0;
                if(data['educationalLevel'] != null){
                    len = data['educationalLevel'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['educationalLevel'][i].id;
                        var name = data['educationalLevel'][i].name;
                        if(data.education.educational_level_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#educational_level_id").append(option);
                    }
                }

                $('#subject_id').val(data.education.subject_id);
                var len = 0;
                if(data['subjects'] != null){
                    len = data['subjects'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['subjects'][i].id;
                        var name = data['subjects'][i].name;
                        if(data.education.subject_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#subject_id").append(option);
                    }
                }

                $('#university_id').val(data.education.university_id);
                var len = 0;
                if(data['universities'] != null){
                    len = data['universities'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['universities'][i].id;
                        var name = data['universities'][i].name;
                        if(data.education.university_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#university_id").append(option);
                    }
                }

                $('#education_mode_id').val(data.education.education_mode_id);
                var len = 0;
                if(data['educationModes'] != null){
                    len = data['educationModes'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['educationModes'][i].id;
                        var name = data['educationModes'][i].name;
                        if(data.education.education_mode_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#education_mode_id").append(option);
                    }
                }

                $('#editEducationModal').modal();
            }
        })
    });

    $('body').on('click', '.viewEducation', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-education.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data.education);
                $("#viewEducationModel").modal("show");
                document.getElementById('qualification').innerText = data.education.education_level.name;
                document.getElementById('subject').innerText = data.education.subject.name;
                document.getElementById('specialization').innerText = data.education.specialization;
                document.getElementById('university').innerText = data.education.university.name;
                document.getElementById('fromDate').innerText = data.education.from_year;
                document.getElementById('toDate').innerText = data.education.to_year;
                document.getElementById('percentage').innerText = data.education.percentage;
                document.getElementById('modeOfStudy').innerText = data.education.education_mode.name;
            }
        })
    });

    if ($("#editEducationForm").length > 0)
    {
        $("#editEducationForm").validate({
          rules: {
            specialization: {
              required: true,
              maxlength: 50
            },
            educational_level_id: {
              required: true,
            },
            subject_id: {
              required: true,
            },
            university_id: {
              required: true,
            },
            from: {
              required: true,
            },
            to: {
              required: true,
            },
            percentage: {
              required: true,
            },
            education_mode: {
              required: true,
            },
          },
          messages: {
            specialization: {
              required: "Please enter specialization",
              maxlength: "Your last specialization maxlength should be 50 characters long."
            },
            educational_level_id: {
              required: "Please enter qualification",
            },
            subject_id: {
              required: "Please enter subject",
            },
            university_id: {
              required: "Please enter university",
            },
            from_year: {
              required: "Please enter from date",
            },
            to_year: {
              required: "Please enter to date",
            },
            percentage: {
              required: "Please enter percentage",
            },
            education_mode: {
              required: "Please enter education mode",
            },
          },
          submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $('#education_id').val();
            var url = '{{ route("candidate-education.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editEducationForm').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editEducationForm').trigger("reset");
                  $('.educationDatatable').DataTable().ajax.reload();
                  $('#res_message').fadeIn().html(
                      '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                      response.message +
                      '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                      );
                  setTimeout(function() {
                      $('#res_message').fadeIn().fadeOut();
                  }, 4000);
              },
              error: function (data) {
                    console.log('Error:', data);
                }
            });
          }
        })
    }
    </script>
@endpush