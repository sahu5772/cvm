<div class="tab-pane fade" id="pills-professional" role="tabpanel" aria-labelledby="pills-professional-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Professional Details</div>
                    @if (auth()->user()->hasPermissionTo('professional details.add'))
                    <button class="btn_style drawerMenu-Profession">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        {{ __('messages.add')}} {{ __('messages.candidate.professional_details')}}
                    </button>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <table class="table candidateExperience">
                                <thead>
                                    <tr>
                                        <th scope="col" width="18%">Company</th>
                                        <th scope="col" width="10%">From Date</th>
                                        <th scope="col" width="10%">To Date</th>
                                        <th scope="col" width="18%">Designation</th>
                                        <th scope="col" width="5%"></th>
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
</div>


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
                                    Profesional Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Company</span>
                                        <p id="company"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>From Date</span>
                                        <p id="fromDte"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>To Date</span>
                                        <p id="toDate"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Designation</span>
                                        <p id="designation"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>H.O.Country</span>
                                        <p id="country"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Job Type</span>
                                        <p id="jobType"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Responsibilities</span>
                                        <p id="responsibilities"></p>
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
<div class="modal fade" id="editProfessionalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="editProfessionalForm" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Company<span class="reqText">*</span></label>
                                <input type="text" name="company_name" id="company_name" value="" placeholder="Enter Company Name">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">From Date<span class="reqText">*</span></label>
                                <input type="date" name="from_date" id="from_date" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6" id="endDateDiv">
                            <div class="input_grp">
                                <label for="">To Date<span class="reqText">*</span></label>
                                <input type="date" name="to_date" id="to_date" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <label class="switch" for="">Curently working with the organization<span class="reqText">*</span></label>
                            <input type="checkbox" id="currentlyWorkingEdit" value="false" name="currently_working">
                            <div class="slider round"></div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Designation<span class="reqText">*</span></label>
                                <select class="form-control" name="designation_id" id="designation_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Country<span class="reqText">*</span></label>
                                <select class="form-control" name="country_id" id="country_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Job Type<span class="reqText">*</span></label>
                                <select class="form-control" name="job_type_id" id="job_type_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Responsibilities<span class="reqText">*</span></label>
                                <input type="text" name="responsibilities" id="responsibility" value="" placeholder="type here...">
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

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.candidateExperience').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('candidate-work-experience.index') }}",
                    data: function (d) {
                        d.candidate_id = '{{ $candidate->id}}'
                        }
                },
            columns: [
                {data: 'company', name: 'company'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'designation', name: 'designation'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('body').on('click', '.deleteExperience', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-work-experience.destroy", ":id") }}';
            url = url.replace(':id', id);

        Swal.fire({
            title             : "Delete",
            text              : "Do you realy want to delete!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Yes, Delete this experence!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url    : url,
                    type   : "delete",
                    success: function(data) {
                            if (data.success) {
                            $('.candidateExperience').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    });

    $('body').on('click', '.viewExperience', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-work-experience.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data);
                $("#viewProfessionalModel").modal("show");
                document.getElementById('company').innerText = data.candidateWorkExperience.company_name;
                document.getElementById('fromDte').innerText = data.candidateWorkExperience.from_date;
                document.getElementById('toDate').innerText = (data.candidateWorkExperience.to_date) ? data.candidateWorkExperience.to_date : '-';
                document.getElementById('designation').innerText = data.candidateWorkExperience.designation.name;
                document.getElementById('country').innerText = data.candidateWorkExperience.country.name;
                document.getElementById('jobType').innerText = data.candidateWorkExperience.job_type.name;
                document.getElementById('responsibilities').innerText = data.candidateWorkExperience.responsibilities;
            }
        })
    });

    $('body').on('click', '.editExperience', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-work-experience.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#id').val(data.candidateWorkExperience.id);
                $('#company_name').val(data.candidateWorkExperience.company_name);
                $('#from_date').val(data.candidateWorkExperience.from_date);
                if(data.candidateWorkExperience.to_date == null)
                {
                    $("#endDateDiv").hide();
                }
                else
                {
                    $('#to_date').val(data.candidateWorkExperience.to_date);
                }
                $('#responsibility').val(data.candidateWorkExperience.responsibilities);

                $('#designation_id').val(data.candidateWorkExperience.designation_id);
                var len = 0;
                if(data['designation'] != null){
                    len = data['designation'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['designation'][i].id;
                        var name = data['designation'][i].name;
                        if(data.candidateWorkExperience.designation_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#designation_id").append(option);
                    }
                }

                $('#country_id').val(data.candidateWorkExperience.country_id);
                var len = 0;
                if(data['country'] != null){
                    len = data['country'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['country'][i].id;
                        var name = data['country'][i].name;
                        if(data.candidateWorkExperience.country_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#country_id").append(option);
                    }
                }

                $('#job_type_id').val(data.candidateWorkExperience.job_type_id);
                var len = 0;
                if(data['jobType'] != null){
                    len = data['jobType'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['jobType'][i].id;
                        var name = data['jobType'][i].name;
                        if(data.candidateWorkExperience.job_type_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#job_type_id").append(option);
                    }
                }

                $('#editProfessionalModal').modal();
            }
        })
    });

    if ($("#editProfessionalForm").length > 0)
    {
        $("#editProfessionalForm").validate({
          rules: {
            company_name: {
              required: true,
              maxlength: 50
            },
            from_date: {
              required: true,
            },
            responsibilities: {
              required: true,
            },
            designation_id: {
              required: true,
            },
            country_id: {
              required: true,
            },
            job_type_id: {
              required: true,
            }
          },
          submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $('#id').val();
            var url = '{{ route("candidate-work-experience.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editProfessionalForm').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editProfessionalForm').trigger("reset");
                  $('.candidateExperience').DataTable().ajax.reload();
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