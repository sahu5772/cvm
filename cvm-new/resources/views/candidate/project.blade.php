<div class="tab-pane fade" id="pills-project" role="tabpanel" aria-labelledby="pills-project-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Project Details</div>
                    @if (auth()->user()->hasPermissionTo('project details.add'))
                    <button class="btn_style drawerMenu-form">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        Add Project Details
                    </button>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <table class="table candidateProject">
                                <thead>
                                    <tr>
                                        <th scope="col" width="18%">Name of Project</th>
                                        <th scope="col" width="10%">From Date</th>
                                        <th scope="col" width="10%">To Date</th>
                                        <th scope="col" width="18%">Designation</th>
                                        <th scope="col" width="12%">Industry</th>
                                        <th scope="col" width="12%">Sector</th>
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
<div class="modal fade" id="viewProjectModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    Project Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Name of Project</span>
                                        <p id="projectName"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project Duration(From)</span>
                                        <p id="from"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project Duration(To)</span>
                                        <p id="to"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Designation</span>
                                        <p id="designation"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Industry</span>
                                        <p id="industry"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Sector</span>
                                        <p id="sector"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Phase</span>
                                        <p id="phase"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Name of Employer</span>
                                        <p id="employerName"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Nature of Employer</span>
                                        <p id="employerNature"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project Experience</span>
                                        <p id="projectExperience"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project Country</span>
                                        <p id="country"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project State</span>
                                        <p id="state"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project City</span>
                                        <p id="city"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Total Project Length</span>
                                        <p id="projectLenght"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Project Cost</span>
                                        <p id="cost"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Funding Agency</span>
                                        <p id="agency"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Mode of Contract</span>
                                        <p id="contractMode"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Terrain</span>
                                        <p id="terrain"></p>
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
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="editProjectForm" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Name of Project<span class="reqText">*</span></label>
                                <input type="text" name="name" id="name" value="" placeholder="Enter Company Name">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project Duration(From)<span class="reqText">*</span></label>
                                <input type="date" name="from" id="fromDuration" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project Duration(To)<span class="reqText">*</span></label>
                                <input type="date" name="to" id="toDuration" value="" placeholder="type here...">
                            </div>
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
                                <label for="">Industry<span class="reqText">*</span></label>
                                <select class="form-control" name="industry_id" id="industry_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Sector<span class="reqText">*</span></label>
                                <select class="form-control" name="sector_id" id="sector_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Phase<span class="reqText">*</span></label>
                                <select class="form-control" name="phase_id" id="phase_id">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Name of Employer</label>
                                <input type="text" name="employer_name" id="employerNameEdit" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Nature of Employer</label>
                                <select class="form-control" name="employer_type_id" id="employeeType">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project Experience<span class="reqText">*</span></label>
                                <select class="form-control" name="project_type" id="projectType">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project Country<span class="reqText">*</span></label>
                                <select class="form-control" name="country_id" id="countryEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project State<span class="reqText">*</span></label>
                                <select class="form-control" name="state_id" id="stateEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project City<span class="reqText">*</span></label>
                                <select class="form-control" name="city_id" id="cityEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Total Project Length<span class="reqText">*</span></label>
                                <input type="text" name="project_length" id="projectLength" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Project Cost<span class="reqText">*</span></label>
                                <input type="text" name="project_cost" id="projectCost" value="" placeholder="type here...">
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Funding Agency<span class="reqText">*</span></label>
                                <select class="form-control" name="funding_agency_id" id="fundingAgencyEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Mode of Contract<span class="reqText">*</span></label>
                                <select class="form-control" name="contract_mode_id" id="contractModeEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Terrain<span class="reqText">*</span></label>
                                <select class="form-control" name="terrain_id" id="terrainEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn_style ghost_btn closeModal" data-dismiss="modal">
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

        var table = $('.candidateProject').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('candidate-project.index') }}",
                    data: function (d) {
                        d.candidate_id = '{{ $candidate->id}}'
                        }
                },
            columns: [
                {data: 'project', name: 'project'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'designation', name: 'designation'},
                {data: 'industry', name: 'industry'},
                {data: 'sector', name: 'sector'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('body').on('click', '.deleteProject', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-project.destroy", ":id") }}';
            url = url.replace(':id', id);

        Swal.fire({
            title             : "Delete",
            text              : "Do you realy want to delete!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Yes, Delete this project!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url    : url,
                    type   : "delete",
                    success: function(data) {
                            if (data.success) {
                            $('.candidateProject').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    });

    $('body').on('click', '.viewProject', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-project.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data);
                $("#viewProjectModel").modal("show");
                document.getElementById('projectName').innerText = data.project.name;
                document.getElementById('from').innerText = data.project.from;
                document.getElementById('to').innerText = data.project.to;
                document.getElementById('designation').innerText = data.project.designation.name;
                document.getElementById('industry').innerText = data.project.industry.name;
                document.getElementById('sector').innerText = data.project.sector.name;
                document.getElementById('phase').innerText = data.project.phase.name;
                document.getElementById('employerName').innerText = (data.project.employer_name) ? data.project.employer_name : '-';
                document.getElementById('employerNature').innerText = (data.project.employer_type) ? data.project.employer_type : '-';
                document.getElementById('projectExperience').innerText = data.project.project_type;
                document.getElementById('country').innerText = data.project.country.name;
                document.getElementById('state').innerText = data.project.state.name;
                document.getElementById('city').innerText = data.project.city.name;
                document.getElementById('projectLenght').innerText = data.project.project_length;
                document.getElementById('cost').innerText = (data.project.project_cost) ? data.project.project_cost : '-';
                document.getElementById('agency').innerText = data.project.funding_agency.name;
                document.getElementById('contractMode').innerText = data.project.contract_mode.name;
                document.getElementById('terrain').innerText = data.project.terrain.name;
            }
        })
    });

    $('body').on('click', '.editProject', function () {

        $('#editProjectModal').modal();
        var id = $(this).data("id");
        var url = '{{ route("candidate-project.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#id').val(data.candidateProject.id);
                $('#name').val(data.candidateProject.name);
                $('#fromDuration').val(data.candidateProject.from);
                $('#toDuration').val(data.candidateProject.to);
                $('#employerNameEdit').val(data.candidateProject.employer_name);
                $('#projectLength').val(data.candidateProject.project_length);
                $('#projectCost').val(data.candidateProject.project_cost);

                $('#designation_id').val(data.candidateProject.designation_id);
                var len = 0;
                if(data['designation'] != null){
                    len = data['designation'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['designation'][i].id;
                        var name = data['designation'][i].name;
                        if(data.candidateProject.designation_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#designation_id").append(option);
                    }
                }

                $('#projectType').val(data.candidateProject.project_type);
                if(data.candidateProject.project_type == 'National'){
                    var option = "<option value='National' selected>National</option>";
                }else{
                    var option = "<option value='International' >International</option>";
                }
                $("#projectType").append(option);

                $('#employeeType').val(data.candidateProject.employer_type_id);
                var len = 0;
                if(data['employeeType'] != null){
                    len = data['employeeType'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['employeeType'][i].id;
                        var name = data['employeeType'][i].name;
                        if(data.candidateProject.employer_type_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#employeeType").append(option);
                    }
                }

                $('#industry_id').val(data.candidateProject.industry_id);
                var len = 0;
                if(data['industry'] != null){
                    len = data['industry'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['industry'][i].id;
                        var name = data['industry'][i].name;
                        if(data.candidateProject.industry_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#industry_id").append(option);
                    }
                }

                $('#sector_id').val(data.candidateProject.sector_id);
                var len = 0;
                if(data['sector'] != null){
                    len = data['sector'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['sector'][i].id;
                        var name = data['sector'][i].name;
                        if(data.candidateProject.sector_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#sector_id").append(option);
                    }
                }

                $('#phase_id').val(data.candidateProject.phase_id);
                var len = 0;
                if(data['phase'] != null){
                    len = data['phase'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['phase'][i].id;
                        var name = data['phase'][i].name;
                        if(data.candidateProject.phase_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#phase_id").append(option);
                    }
                }

                $('#countryEdit').val(data.candidateProject.country_id);
                var len = 0;
                if(data['countries'] != null){
                    len = data['countries'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['countries'][i].id;
                        var name = data['countries'][i].name;
                        if(data.candidateProject.country_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#countryEdit").append(option);
                    }
                }

                $('#stateEdit').val(data.candidateProject.state_id);
                var len = 0;
                if(data['states'] != null){
                    len = data['states'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['states'][i].id;
                        var name = data['states'][i].name;
                        if(data.candidateProject.state_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#stateEdit").append(option);
                    }
                }

                $('#cityEdit').val(data.candidateProject.city_id);
                var len = 0;
                if(data['cities'] != null){
                    len = data['cities'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['cities'][i].id;
                        var name = data['cities'][i].name;
                        if(data.candidateProject.city_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#cityEdit").append(option);
                    }
                }

                $('#fundingAgencyEdit').val(data.candidateProject.funding_agency_id);
                var len = 0;
                if(data['fundingAgencies'] != null){
                    len = data['fundingAgencies'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['fundingAgencies'][i].id;
                        var name = data['fundingAgencies'][i].name;
                        if(data.candidateProject.funding_agency_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#fundingAgencyEdit").append(option);
                    }
                }

                $('#contractModeEdit').val(data.candidateProject.contract_mode_id);
                var len = 0;
                if(data['contractMode'] != null){
                    len = data['contractMode'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['contractMode'][i].id;
                        var name = data['contractMode'][i].name;
                        if(data.candidateProject.contract_mode_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#contractModeEdit").append(option);
                    }
                }

                $('#terrainEdit').val(data.candidateProject.contract_mode_id);
                var len = 0;
                if(data['terrains'] != null){
                    len = data['terrains'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['terrains'][i].id;
                        var name = data['terrains'][i].name;
                        if(data.candidateProject.contract_mode_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#terrainEdit").append(option);
                    }
                }

            }
        })
    });

    if ($("#editProjectForm").length > 0)
    {
        $("#editProjectForm").validate({
          rules: {
            name: {
              required: true,
              maxlength: 50
            },
            from: {
              required: true,
            },
            to: {
              required: true,
            },
            designation_id: {
              required: true,
            },
            country_id: {
              required: true,
            },
            industry_id: {
              required: true,
            },
            sector_id: {
              required: true,
            },
            phase_id: {
              required: true,
            },
            employer_name: {
              required: true,
            },
            employer_type_id: {
              required: true,
            },
            project_type: {
              required: true,
            },
            state_id: {
              required: true,
            },
            city_id: {
              required: true,
            },
            project_length: {
              required: true,
            },
            project_cost: {
              required: true,
            },
            funding_agency_id: {
              required: true,
            },
            contract_mode_id: {
              required: true,
            },
            terrain_id: {
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
            var url = '{{ route("candidate-project.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editProjectForm').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editProjectForm').trigger("reset");
                  $('.closeModal').click();
                  $('.candidateProject').DataTable().ajax.reload();
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