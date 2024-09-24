<div class="tab-pane fade" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab">
    <main class="candidate_Educational_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Address Details</div>
                    @if (auth()->user()->hasPermissionTo('address details.add'))
                    <button class="btn_style  drawerMenu-address">
                        <img src="{{ asset('images/icons/diploma.png')}}" alt="" />
                        Add Address Details
                    </button>
                    @endif
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <table class="table addressDatatable">
                                <thead>
                                    <tr>
                                        <th scope="col" width="32%">Address</th>
                                        <th scope="col" width="12%">Country</th>
                                        <th scope="col" width="12%">State</th>
                                        <th scope="col" width="12%">City</th>
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
<div class="modal fade" id="viewAddressModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    Address Details
                                </div>
                                <div class="card-body">
                                    <div class="card-detail">
                                        <span>Address</span>
                                        <p id="address"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>Country</span>
                                        <p id="country"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>State</span>
                                        <p id="state"></p>
                                    </div>
                                    <div class="card-detail">
                                        <span>City</span>
                                        <p id="city"></p>
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
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form id="editAddressForm" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Address<span class="reqText">*</span></label>
                                <input type="text" name="address" id="addressEdit" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Country<span class="reqText">*</span></label>
                                <select class="form-control" name="country_id" id="countryEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">State<span class="reqText">*</span></label>
                                <select class="form-control" name="state_id" id="stateEdit">
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">City<span class="reqText">*</span></label>
                                <select class="form-control" name="city_id" id="cityEdit">
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

        var table = $('.addressDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url: "{{ route('candidate-address.index') }}",
                    data: function (d) {
                        d.candidate_id = '{{ $candidate->id}}'
                    }
                },
            columns: [
                {data: 'address', name: 'address'},
                {data: 'country', name: 'country'},
                {data: 'state', name: 'state'},
                {data: 'city', name: 'city'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $('body').on('click', '.deleteAddress', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-address.destroy", ":id") }}';
            url = url.replace(':id', id);

        Swal.fire({
            title             : "Delete",
            text              : "Do you realy want to delete!",
            icon              : "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Yes, Delete this address!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url    : url,
                    type   : "delete",
                    success: function(data) {
                            if (data.success) {
                            $('.addressDatatable').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    });

    $('body').on('click', '.viewAddress', function () {

        var id = $(this).data("id");
        var url = '{{ route("candidate-address.show", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {
                console.log(data.address);
                $("#viewAddressModel").modal("show");
                document.getElementById('address').innerText = data.address.address;
                document.getElementById('country').innerText = data.address.country.name;
                document.getElementById('state').innerText = data.address.state.name;
                document.getElementById('city').innerText = data.address.city.name;
            }
        })
    });

    $('body').on('click', '.editAddress', function () {

        $('#editAddressModal').modal();
        var id = $(this).data("id");
        var url = '{{ route("candidate-address.edit", ":id") }}';
        url = url.replace(':id', id);

        $.ajax({
            url    : url,
            type   : "get",
            success: function(data) {

                $('#id').val(data.candidateAddress.id);
                $('#addressEdit').val(data.candidateAddress.address);

                $('#countryEdit').val(data.candidateAddress.country_id);
                var len = 0;
                if(data['countries'] != null){
                    len = data['countries'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['countries'][i].id;
                        var name = data['countries'][i].name;
                        if(data.candidateAddress.country_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#countryEdit").append(option);
                    }
                }

                $('#stateEdit').val(data.candidateAddress.state_id);
                var len = 0;
                if(data['states'] != null){
                    len = data['states'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['states'][i].id;
                        var name = data['states'][i].name;
                        if(data.candidateAddress.state_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#stateEdit").append(option);
                    }
                }

                $('#cityEdit').val(data.candidateAddress.city_id);
                var len = 0;
                if(data['cities'] != null){
                    len = data['cities'].length;
                }
                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = data['cities'][i].id;
                        var name = data['cities'][i].name;
                        if(data.candidateAddress.city_id == id){
                        var option = "<option value='"+id+"' selected>"+name+"</option>";
                        }else{
                            var option = "<option value='"+id+"'>"+name+"</option>";
                        }
                        $("#cityEdit").append(option);
                    }
                }

            }
        })
    });

    if ($("#editAddressForm").length > 0)
    {
        $("#editAddressForm").validate({
          rules: {
            address: {
              required: true,
              maxlength: 50
            },
            country_id: {
              required: true,
            },
            state_id: {
              required: true,
            },
            city_id: {
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
            var url = '{{ route("candidate-address.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#editAddressForm').serialize(),
              success: function( response ) {
                console.log(response);
                  $('#editAddressForm').trigger("reset");
                  $('.closeModal').click();
                  $('.addressDatatable').DataTable().ajax.reload();
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