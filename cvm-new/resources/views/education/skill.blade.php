@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Skill</div>
        <div class="row">
            <div class="col-4">
                <div id="skill">
                    <form method="POST" id="skillForm" name="skillForm">
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
                        <div class="button_flex">
                            <button type="submit" class="btn_style">Save</button>
                            <button type="reset" class="btn_style ghost_btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-8">
                <div class="table__wrapper">
                    <table class="table skill-datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="30%">#</th>
                                <th scope="col" width="30%">Name</th>
                                <th scope="col" width="30%">Status</th>
                                <th scope="col" width="30%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="skill-datatable-value">
                        </tbody>
                    </table>
                </div>
                <!-- ./table__wrapper -->
            </div>

        </div>
        <!-- ./row -->
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
            $.ajax({
                type: 'GET',
                url: '{{ route('skill.index') }}',
                dataType: 'JSON',
                success: function(response) {
                    $('#skill-datatable-value').html(response.data);
                }
            });
        });

        if ($("#skillForm").length > 0) {

            $("#skillForm").validate({

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
                        url: '{{ route('skill.store') }}',
                        type: "POST",
                        data: $('#skillForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            $('#skillForm').trigger("reset");
                            $('#skill-datatable-value').html(response.data);
                        },
                        error: function(response) {
                        }
                    });
                }

            });
        }

        function deleteSkill(e) {
            var url = '{{ route('skill.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this skill!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this skill!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('#skill-datatable-value').html(data.data);
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
