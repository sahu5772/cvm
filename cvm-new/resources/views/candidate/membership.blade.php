<div class="tab-pane fade" id="pills-member" role="tabpanel" aria-labelledby="pills-member-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Membership Details</div>
                    @if (auth()->user()->hasPermissionTo('membership details.add'))
                    <button class="btn_style  drawerMenu-member">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        Add Membership Details
                    </button>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <table class="table membershipDatatable">
                                <thead>
                                    <tr>
                                        <th scope="col" width="22%">Membership</th>
                                        <th scope="col" width="18%">Membership Number</th>
                                        <th scope="col" width="12%">Year of Awarded</th>
                                        <th scope="col" width="12%">Types of Membership</th>
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
<div class="modal fade" id="viewMembershipModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    Membership Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Membership</span>
                                        <p id="membership"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Membership Number</span>
                                        <p id="membershipNumber"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Year of Awarded</span>
                                        <p id="year"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Type of Membership</span>
                                        <p id="membershipType"></p>
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
<div class="modal fade" id="editMembershipModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="editMembershipSubmit" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Membership<span class="reqText">*</span></label>
                                <select class="form-control" name="membership_id" id="membershipEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Membership Number<span class="reqText">*</span></label>
                                <input type="text" name="membership_number" id="membershipNumberEdit" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Year of Awarded<span class="reqText">*</span></label>
                                <input type="text" class="form-control datepicker" name="year_of_award" id="yearAwardEdit" placeholder="select year..."  />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Type of Membership<span class="reqText">*</span></label>
                                <input type="text" name="type" id="membershipTypeEdit" placeholder="type here..." />
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

        var table = $('.membershipDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('candidate-membership.index') }}",
                    data: function (d) {
                        d.candidate_id = '{{ $candidate->id}}'
                    }
                },
            columns: [
                {data: 'membership', name: 'membership'},
                {data: 'number', name: 'number'},
                {data: 'year', name: 'year'},
                {data: 'type', name: 'type'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('body').on('click', '.deleteMembership', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-membership.destroy", ":id") }}';
            url = url.replace(':id', id);

        Swal.fire({
            title             : "Delete",
            text              : "Do you realy want to delete!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Yes, Delete this education!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url    : url,
                    type   : "delete",
                    success: function(data) {
                            if (data.success) {
                            $('.membershipDatatable').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    });

    $('body').on('click', '.viewMembership', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-membership.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data.membership);
                $("#viewMembershipModel").modal("show");
                document.getElementById('membership').innerText = data.membership.membership.name;
                document.getElementById('membershipNumber').innerText = data.membership.membership_number;
                document.getElementById('year').innerText = data.membership.year_of_award;
                document.getElementById('membershipType').innerText = data.membership.type;
            }
        })
    });

    $('body').on('click', '.editMembership', function () {

        $('#editMembershipModal').modal();
        var id = $(this).data("id");
        var url = '{{ route("candidate-membership.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#id').val(data.candidateMembership.id);
                $('#membershipNumberEdit').val(data.candidateMembership.membership_number);
                $('#yearAwardEdit').val(data.candidateMembership.year_of_award);

                $('#membershipEdit').val(data.candidateMembership.membership_id);
                var len = 0;
                if(data['membership'] != null){
                    len = data['membership'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['membership'][i].id;
                        var name = data['membership'][i].name;
                        if(data.candidateMembership.membership_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#membershipEdit").append(option);
                    }
                }

            }
        })
    });

    if ($("#editMembershipSubmit").length > 0)
    {
        $("#editMembershipSubmit").validate({
          rules: {
            membership_id: {
              required: true,
            },
            membership_number: {
              required: true,
            },
            year_of_award: {
              required: true,
            },
            type: {
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
            var url = '{{ route("candidate-membership.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editMembershipSubmit').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editMembershipSubmit').trigger("reset");
                  $('.closeModal').click();
                  $('.membershipDatatable').DataTable().ajax.reload();
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