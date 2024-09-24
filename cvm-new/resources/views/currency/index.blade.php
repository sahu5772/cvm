@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Currency</div>
        <div class="row">
            <div class="col-4">
                <div id="currency">
                    <form method="POST" id="CurrencyForm" name="CurrencyForm">
                        @csrf
                        <div class="add__option">
                            <div class="input_grp">
                                <label for="">{{ __('messages.name')}} <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                    placeholder="Name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="input_grp">
                                <label for="">{{ __('messages.currency.currency')}} {{ __('messages.currency.symbol')}} <span class="text-danger">*</span></label>
                                <input value="{{ old('currency_symbol') }}" type="text" class="form-control"
                                    name="currency_symbol" placeholder="currency symbol" required>
                                @if ($errors->has('currency_symbol'))
                                    <span class="text-danger text-left">{{ $errors->first('currency_symbol') }}</span>
                                @endif
                            </div>
                            <div class="input_grp">
                                <label for="">{{ __('messages.currency.currency')}} {{ __('messages.currency.code')}} <span class="text-danger">*</span></label>
                                <input value="{{ old('currency_code') }}" type="text" class="form-control"
                                    name="currency_code" placeholder="currency code" required>
                                @if ($errors->has('currency_code'))
                                    <span class="text-danger text-left">{{ $errors->first('currency_code') }}</span>
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
                    <table class="table currency_datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="18%">Sr No.</th>
                                <th scope="col">{{ __('messages.name')}}</th>
                                <th scope="col">{{ __('messages.currency.currency')}} {{ __('messages.currency.symbol')}}</th>
                                <th scope="col">{{ __('messages.currency.currency')}} {{ __('messages.currency.code')}}</th>
                                <th scope="col">{{ __('messages.action')}}</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.edit')}} {{ __('messages.currency.currency')}}</h5>
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
                            <input type="hidden" name="currency_id" id="currency_id" value="">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input_grp">
                                        <label for="">{{ __('messages.name')}} <span class="reqText">*</span></label>

                                        <input type="text" name="name" id="name" value=""
                                            placeholder="Enter Currency Name ...">
                                    </div>
                                    <div class="input_grp">
                                        <label for="">{{ __('messages.currency.currency')}} {{ __('messages.currency.symbol')}}<span class="reqText">*</span></label>

                                        <input type="text" name="currency_symbol" id="currency_symbol" value=""
                                            placeholder="Enter Currency currency symbol ...">
                                    </div>
                                    <div class="input_grp">
                                        <label for="">{{ __('messages.currency.currency')}} {{ __('messages.currency.code')}}<span class="reqText">*</span></label>

                                        <input type="text" name="currency_code" id="currency_code" value=""
                                            placeholder="Enter Currency currency code ...">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn_style ghost_btn" data-dismiss="modal">{{ __('messages.close')}}</button>
                        <button type="submit" class="btn_style" id="saveBtn">{{ __('messages.save')}} {{ __('messages.change')}}</button>

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
            var table = $('.currency_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('currency.index') }}",
                columns: [
                    {data: 'DT_RowIndex',name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'currency_symbol',name: 'currency_symbol'},
                    {data: 'currency_code',name: 'currency_code'},
                    {data: 'action',name: 'action'},
                ]
            });
        });

        if ($("#CurrencyForm").length > 0) {

            $("#CurrencyForm").validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    currency_symbol: {
                        required: true,
                        maxlength: 50
                    },
                    currency_code: {
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
                    currency_symbol: {
                        required: "Please enter currency symbol",
                        maxlength: "Your currency symbol name maxlength should be 50 characters long."
                    },
                    currency_code: {
                        required: "Please enter currency code",
                        maxlength: "Your currency code maxlength should be 50 characters long."
                    },
                    // Add more validation messages as needed
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('currency.store') }}',
                        type: "POST",
                        data: $('#CurrencyForm').serialize(),
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                $('#CurrencyForm').trigger("reset");
                                $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                            +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                                 setTimeout(function() {
                                $('.currency_datatable').DataTable().ajax.reload();
                                $('#res_message').fadeOut("Slow");
                                 }, 4000);
                            } else {
                                $.each(response.error, function(field_name, error) {
                                    $(document).find('[name=' + field_name + ']').after(
                                        '<label class="error" for="company_name">' +
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

            var validator = $("#UpdateForm").validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    currency_symbol: {
                        required: true,
                        maxlength: 50
                    },
                    currency_code: {
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
                    currency_symbol: {
                        required: "Please enter currency symbol",
                        maxlength: "Your currency symbol name maxlength should be 50 characters long."
                    },
                    currency_code: {
                        required: "Please enter currency code",
                        maxlength: "Your currency code maxlength should be 50 characters long."
                    },
                    // Add more validation messages as needed
                },
                submitHandler: function(form) {
                    var id = $('#currency_id').val();
                    var url = '{{ route('currency.update', ':id') }}';
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
                                $('.currency_datatable').DataTable().ajax.reload();
                            }, 4000);
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
        function editCurrency(id) {
            var url = '{{ route('currency.edit', ':id') }}';
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
                    $('#currency_symbol').val(response.data.currency_symbol);
                    $('#currency_code').val(response.data.currency_code);
                    var option;
                    if (response.data.is_active === 'Active') {
                        option += "<option value='" + response.data.is_active + "' selected>" + response.data
                            .is_active + "</option>";
                        option += "<option value='Inactive'>Inactive</option>";
                    } else {
                        option = "<option value='Active'>Active</option>";
                        option += "<option value='" + response.data.is_active + "' selected>" + response.data
                            .is_active + "</option>";
                    }
                    $("#is_active").html(option);

                    $('#currency_id').val(response.data.id);
                    $('#editModal').modal();
                    // $('#myModal').modal('show');

                }
            });

        }


        function deleteCurrency(e) {
            var url = '{{ route('currency.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this currency !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this currency!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('.currency_datatable').DataTable().ajax.reload();
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
