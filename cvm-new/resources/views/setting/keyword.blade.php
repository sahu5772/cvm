@extends('layouts.app')
@section('content')
    <main class="master__wrapper">
        @include('layouts.sidemenu')

        <section class="inner__wrapper">
            <div class="title">keyword</div>
            <div class="row">
                <div class="col-4">
                    <div id="jobType">
                        <form method="POST" id="keywordForm" name="keywordForm">
                            @csrf
                            <div class="add__option">
                                <div class="input_grp">
                                    <label for="">Phase Name</label>
                                    <select name="phase_id" id="phase">
                                        <option value="" selected>Select option</option>
                                        @foreach ($phases as $phase)
                                            <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('phase_id')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
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
                        <table class="table keyword-datatable">
                            <thead>
                                <tr>
                                    <th scope="col" width="30%">No.</th>
                                    <th scope="col" width="30%">Name</th>
                                    <th scope="col" width="30%">Phase</th>
                                    <th scope="col" width="30%">Action</th>
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
            var table = $('.keyword-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('keyword.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'keyword',
                        name: 'keyword'
                    },
                    {
                        data: 'phase',
                        name: 'phase'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });






        if ($("#keywordForm").length > 0) {

            $("#keywordForm").validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    // Add more validation rules as needed
                },
                messages: {
                    name: {
                        required: "Please enter name",
                        maxlength: "Your name maxlength should be 50 characters long."
                    },
                    // Add more validation messages as needed
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('keyword.store') }}',
                        type: "POST",
                        data: $('#keywordForm').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.message);
                            $('#keywordForm').trigger("reset");
                            $('#res_message').fadeIn().html(
                                '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                                response.message +
                                '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                                );
                            setTimeout(function() {
                                $('#res_message').fadeOut("slow");
                            }, 3000);

                            $('.keyword-datatable').DataTable().ajax.reload();
                        },
                        error: function(response) {}
                    });
                }

            });
        }

        function deleteValue(e) {
            var url = '{{ route('keyword.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this keyword!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this keyword!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('.keyword-datatable').DataTable().ajax.reload();
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
