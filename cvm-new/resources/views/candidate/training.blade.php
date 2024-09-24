<div class="tab-pane fade" id="pills-training" role="tabpanel" aria-labelledby="pills-training-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Training Details</div>
                    @if (auth()->user()->hasPermissionTo('training details.add'))
                    <button class="btn_style  drawerMenu-training">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        Add Training Details
                    </button>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <table class="table candidateTraining">
                                <thead>
                                    <tr>
                                        <th scope="col" width="22%">
                                            Training/Certification</th>
                                        <th scope="col" width="18%">Institute</th>
                                        <th scope="col" width="12%">Year</th>
                                        <th scope="col" width="12%">Duration</th>
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
<div class="modal fade" id="viewTrainingModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    Training Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Training/Certification</span>
                                        <p id="training"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Institute/Training Center</span>
                                        <p id="center"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Year of Completion</span>
                                        <p id="year"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Duration</span>
                                        <p id="duration"></p>
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
<div class="modal fade" id="editTrainingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="editTrainingForm" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Training/Certification<span class="reqText">*</span></label>
                                <select class="form-control" name="certificate_id" id="traningEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Institute/Training Center<span class="reqText">*</span></label>
                                <input type="text" name="training_center" id="trainingCenter" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Year of Completion<span class="reqText">*</span></label>
                                <input type="text" class="form-control datepicker" name="year_of_completion" id="yearEdit" placeholder="select year..."  />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Duration<span class="reqText">*</span></label>
                                <input type="number" name="duration" id="durationEdit" placeholder="type here..." />
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

    $(".datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.candidateTraining').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('candidate-training.index') }}",
                    data: function (d) {
                        d.candidate_id = '{{ $candidate->id}}'
                        }
                },
            columns: [
                {data: 'training', name: 'training'},
                {data: 'institute', name: 'institute'},
                {data: 'year', name: 'year'},
                {data: 'duration', name: 'duration'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('body').on('click', '.deleteTraining', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-training.destroy", ":id") }}';
            url = url.replace(':id', id);

        Swal.fire({
            title             : "Delete",
            text              : "Do you realy want to delete!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Yes, Delete this training!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url    : url,
                    type   : "delete",
                    success: function(data) {
                            if (data.success) {
                            $('.candidateTraining').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    });

    $('body').on('click', '.viewTraining', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-training.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data.training);
                $("#viewTrainingModel").modal("show");
                document.getElementById('training').innerText = data.training.certificate.name;
                document.getElementById('center').innerText = data.training.training_center;
                document.getElementById('year').innerText = data.training.year_of_completion;
                document.getElementById('duration').innerText = data.training.duration;
            }
        })
    });

    $('body').on('click', '.editTraining', function () {

        $('#editTrainingModal').modal();
        var id = $(this).data("id");
        var url = '{{ route("candidate-training.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#id').val(data.candidateTraining.id);
                $('#trainingCenter').val(data.candidateTraining.training_center);
                $('#yearEdit').val(data.candidateTraining.year_of_completion);
                $('#durationEdit').val(data.candidateTraining.duration);

                $('#traningEdit').val(data.candidateTraining.certificate_id);
                var len = 0;
                if(data['certificate'] != null){
                    len = data['certificate'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['certificate'][i].id;
                        var name = data['certificate'][i].name;
                        if(data.candidateTraining.certificate_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#traningEdit").append(option);
                    }
                }

            }
        })
    });

    if ($("#editTrainingForm").length > 0)
    {
        $("#editTrainingForm").validate({
          rules: {
            training_center: {
              required: true,
              maxlength: 50
            },
            certificate_id: {
              required: true,
            },
            year_of_completion: {
              required: true,
            },
            duration: {
              required: true,
            },
          },
          submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var id = $('#id').val();
            var url = '{{ route("candidate-training.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editTrainingForm').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editTrainingForm').trigger("reset");
                  $('.closeModal').click();
                  $('.candidateTraining').DataTable().ajax.reload();
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