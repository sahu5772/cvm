@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Interview Round</div>
        <div class="row">
            <div class="col-4">
                <div id="interviewRound">
                    <form method="POST" id="InterviewRound" name="InterviewRound">
                        @csrf
                        <div class="add__option">
                            <div class="input_grp">
                                <label for="">Name <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                    placeholder="Name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="add__option">
                            <div class="input_grp">
                                <label for="">color <span class="text-danger">*</span></label>
                                <input value="{{ old('color') }}" type="text" class="form-control" name="color"
                                    placeholder="color" required>
                                @if ($errors->has('color'))
                                    <span class="text-danger text-left">{{ $errors->first('color') }}</span>
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
                    <table class="table interview_round_datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="18%">Sr No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Color</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Interview Round</h5>
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
                            <input type="hidden" name="interview_round_id" id="interview_round_id" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input_grp">
                                        <label for="">Name <span class="reqText">*</span></label>

                                        <input type="text" name="name" id="name" value=""
                                            placeholder="Enter Interview Round Name ...">
                                    </div>
                                    <!-- ./input_grp -->
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_grp">
                                        <label for="">Color <span class="reqText">*</span></label>

                                        <input type="text" name="color" id="color" value=""
                                            placeholder="Enter Interview Round Name ...">
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
</main>
@endsection

@push('scripts')
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.interview_round_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('interview-round.index') }}",
                columns: [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'color', name: 'color'},
                    {data: 'action',name: 'action'},
                ]
            });
        });

        if ($("#InterviewRound").length > 0) {

            $("#InterviewRound").validate({

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
                        required: "Please enter interview round name",
                        maxlength: "Your interview round name maxlength should be 50 characters long."
                    },
                    color: {
                        required: "Please Select Status",
                    },
                    // Add more validation messages as needed
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('interview-round.store') }}',
                        type: "POST",
                        data: $('#InterviewRound').serialize(),
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                $('#InterviewRound').trigger("reset");
                                $('#res_message').fadeIn().html(
                              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                                 setTimeout(function() {
                                $('.interview_round_datatable').DataTable().ajax.reload();
                                $('#res_message').fadeOut("Slow");
                                 }, 4000);
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

            $("#UpdateForm").validate({

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
                },
                submitHandler: function(form) {
                    var id = $('#interview_round_id').val();
                    var url = '{{ route('interview-round.update', ':id') }}';
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $('#UpdateForm').serialize(),
                        success: function(response) {
                            $('#UpdateForm').trigger("reset");
                            $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                            +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                            $('#editModal').modal('hide');
                            setTimeout(function() {
                                $('#res_message').fadeOut("Slow");
                                $('.interview_round_datatable').DataTable().ajax.reload();
                            }, 2000);
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        }

        function editInterviewRound(id) {
            var url = '{{ route('interview-round.edit', ':id') }}';
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
                    $('#color').val(response.data.color);
                    $('#interview_round_id').val(response.data.id);
                    $('#editModal').modal();
                    // $('#myModal').modal('show');

                }
            });

        }


        function deleteInterviewRound(e) {
            var url = '{{ route('interview-round.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this interviewRound !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this interviewRound!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('.interview_round_datatable').DataTable().ajax.reload();
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
