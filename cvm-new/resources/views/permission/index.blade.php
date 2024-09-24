@extends('layouts.app')
@section('content')
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Permission</div>
        <div class="row">
            <div class="col-4">
                <div id="permission">
                    <form method="POST" id="PermissionForm" name="PermissionForm">
                        @csrf
                        <div class="add__option">
                            <div class="input_grp">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                    placeholder="Name" id="btn" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            
                        </div>
                        <div class="button_flex">
                            <button type="submit" class="btn_style">Save</button>
                            <button type="reset" class="btn_style ghost_btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-8">
                <div class="table__wrapper">
                    <table class="table permission_datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="18%">Sr No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                                <th scope="col" width="10%"></th>
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

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Permission</h5>
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
                        <div id="res_message"></div>

                        <form id="UpdateForm" name="UpdateForm" class="form-horizontal" method="POST">
                            @method('patch')
                            @csrf
                            <input type="hidden" name="permission_id" id="permission_id" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input_grp">
                                        <label for="">Name <span class="reqText">*</span></label>

                                        <input type="text" name="name" id="name" value=""
                                            placeholder="Enter Permission Name ..." autocomplete="off">
                                    </div>

                                    <!-- ./input_grp -->
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn_style ghost_btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn_style" id="saveBtn">Save changes</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.permission_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('permission.index') }}",
                columns: [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'action',name: 'action'},
                ]
            });
        });

        if ($("#PermissionForm").length > 0) {

            $("#PermissionForm").validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    is_active: {
                        required: true,
                    },
                    // Add more validation rules as needed
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your name maxlength should be 50 characters long."
                    },
                    is_active: {
                        required: "Please Select Status",
                    },
                    // Add more validation messages as needed
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('permission.store') }}',
                        type: "POST",
                        data: $('#PermissionForm').serialize(),
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                $('#PermissionForm').trigger("reset");
                                $('#res_message').fadeIn().html('<p class="alert alert-success">' +
                                    response.message + '</p>');
                                // setTimeout(function() {
                                $('.permission_datatable').DataTable().ajax.reload();
                                $('#res_message').fadeOut("Slow");
                                // }, 2000);
                            } else {
                                $.each(response.error, function(field_name, error) {
                                    $(document).find('[name=' + field_name + ']').after(
                                        '<label class="error" for="name">' +
                                        error + '</label>')
                                })
                            }

                        },
                        error: function(response) {
                            // console.log('Error:', response.error);
                        }
                    });
                }
            });
        }

        if ($("#UpdateForm").length > 0) {
   
          var validator =   $("#UpdateForm").validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    is_active: {
                        required: true,
                    },
                    // Add more validation rules as needed
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your name maxlength should be 50 characters long."
                    },
                    is_active: {
                        required: "Please Select Status",
                    },
                },
                submitHandler: function(form) {
                    var id = $('#permission_id').val();
                    var url = '{{ route('permission.update', ':id') }}';
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $('#UpdateForm').serialize(),
                        success: function(response) {
                            $('#UpdateForm').trigger("reset");
                            $('#res_message').fadeIn().html('<p class="alert alert-success">' +
                                response.message + '</p>');
                            $('#editModal').modal('hide');
                            setTimeout(function() {
                                $('#res_message').fadeOut("Slow");
                                $('.permission_datatable').DataTable().ajax.reload();
                            }, 2000);
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        }
        $('#editModal').on('hidden.bs.modal', function () {
            
            validator.resetForm();
            $('.error').removeClass('error');

        });

        function editPermission(id) {
            var url = '{{ route('permission.edit', ':id') }}';
            url = url.replace(':id', id);
            console.log(url);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: url,
                data: ({
                    id: id,
                    title: 'edit'
                }),
                dataType: 'JSON',
                success: function(response) {
                    $('#name').val(response.data.name);
                    $('#permission_id').val(response.data.id);
                    $('#editModal').modal();
                    // $('#myModal').modal('show');

                }
            });

        }


        function deletePermission(e) {
            var url = '{{ route('permission.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this permission !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this permission!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('.permission_datatable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success')
                            }
                        }
                    })
                }
            })
        }
    </script>
@endpush
