
<div class="modal fade" id="companyLocationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Business Unit</h5>
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
            </div><br>
            <div class="row">
                <div class="col-12">
                    <div class="table__wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Business Unit</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="companyLocationDatatable">
                            </tbody>
                        </table>
                    </div>
                    <!-- ./table__wrapper -->
                </div>
            </div>
            <form id="companyLocationForm" name="companyLocationForm" class="form-horizontal" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" name="company_id" value="" id="company_id"/>
                            <div class="input_grp">
                                <label for="">Branch Name <span class="reqText">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your company branch name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Phone Number <span class="reqText">*</span></label>
                                <input type="number" name="phone_number" value="{{ old('phone_number') }}"
                                    placeholder="Enter your company branch phone number" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Address Name <span class="reqText">*</span></label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                    placeholder="Enter your company branch address" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Country<span class="reqText">*</span></label>
                                <select name="country_id" class="country">
                                    <option value="" selected>Please select country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">State<span class="reqText">*</span></label>
                                <select name="state_id" class="state">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">City<span class="reqText">*</span></label>
                                <select name="city_id" class="city">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Pincode <span class="reqText">*</span></label>
                                <input type="tel" name="pin_code" id="add_company_pin_code"
                                    placeholder="Enter your company pincode" minlength="1" maxlength="6" autocomplete="off" />

                                    @if ($errors->has('pin_code'))
                                    <span class="text-danger text-left">{{ $errors->first('pin_code') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Timezone<span class="reqText">*</span></label>
                                <select name="timezone_id">
                                    <option value="" selected>Please select Timezone</option>
                                    @foreach ($timezones as $timezone)
                                        <option value="{{ $timezone->id }}">{{ $timezone->timezone }}</option>
                                    @endforeach
                                </select>
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
    <script>
        $("#add_company_pin_code").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 6 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});

        $("#companyLocationForm").validate({
            rules: {
                country_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                pin_code: {
                    required: true,
                },
                state_id: {
                    required: true,
                },
                city_id: {
                    required: true,
                },
                timezone_id: {
                    required: true,
                },
                phone_number: {
                    required: true,
                }
            },
            messages: {
                country_id: {
                    required: "Please select country",
                },
                state_id: {
                    required: "Please select state",
                },
                city_id: {
                    required: "Please select city",
                },
                timezone_id: {
                    required: "Please select timezone",
                },
                phone_number: {
                    required: "Please enter phone number",
                },
            }
        })

        $('#companyLocationForm').on('submit', function(event) {
            if ($("#companyLocationForm").valid()) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('business.location-store') }}',
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            $('#companyLocationForm').trigger("reset");
                            $('#companyLocationModal').modal('hide');
                            $('#multiSelectLocation').html('<option value="">-- Select Location --</option>');
                            $.each(response.location, function (key, value) {
                                $("#multiSelectLocation").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                            +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                            $('.company_datatable').DataTable().ajax.reload();
                            setTimeout(function() {
                                $('#res_message').fadeOut("Slow");
                            }, 2000);
                        } else {
                            $.each(response.error, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').after(
                                    '<label class="error" for="company_name">' + error +
                                    '</label>')
                            })
                        }
                    }
                })
            }
        });

        function unit(id) {
            var url = '{{ route('business.company-unit', ':id') }}';
            url = url.replace(':id', id);
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
                    title: 'Business Unit'
                }),
                dataType: 'JSON',
                success: function(response) {
                    $('#companyLocationDatatable').html(response.locations);
                    $('#company_id').val(id);
                    $('#companyLocationModal').modal('show');
                }
            });

        }

        function deleteCompanyLocation(e,c) {
            var url = '{{ route("business.location.destroy") }}';
                url = url.replace(':id', e);
            Swal.fire({
                title             : "Delete",
                text              : "Do you realy want to delete!",
                icon              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor : "#d33",
                confirmButtonText : "Yes, Delete this item!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url    : url,
                        type: "POST",
                        data: {
                            id: e,
                            company_id: c,
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                                if (data.success) {
                                $('#multiSelectLocation').html('<option value="">-- Select Location --</option>');
                                $.each(data.location, function (key, value) {
                                    $("#multiSelectLocation").append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                                $('#companyLocationDatatable').html(data.locations);
                                Swal.fire('Deleted!','Your file has been deleted.',
                                'success')
                                }
                        }
                    })
                }
            })
        }
    </script>
@endpush
