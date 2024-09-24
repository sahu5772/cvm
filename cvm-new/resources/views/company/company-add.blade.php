@extends('layouts.app')
@section('content')
@if ($errors->has('license_by_year_from'))
<div class="toast active">
    <div class="toast-content">
        <i class="fa fa-times-circle text-danger" style="font-size:48px;color:red"></i>

        <div class="message">
            <span class="text text-2 text-danger">{{ $errors->first('license_by_year_from') }}</span>
        </div>
    </div>
    <i class="fa fa-times close"></i>
    <div class="progress  active"></div>
</div>
@endif

@if ($errors->has('license_by_year_to'))
<div class="toast active">
    <div class="toast-content">
        <i class="fa fa-times-circle text-danger" style="font-size:48px;color:red"></i>
        <div class="message">
            <span class="text text-2 text-danger">{{ $errors->first('license_by_year_to') }}</span>
        </div>
    </div>
    <i class="fa fa-times close"></i>
    <div class="progress  active"></div>
</div>
@endif
@if ($errors->has('license_by_user'))
<div class="toast active">
    <div class="toast-content">
        <i class="fa fa-times-circle text-danger" style="font-size:48px;color:red"></i>
        <div class="message">
            <span class="text text-2 text-danger">{{ $errors->first('license_by_user') }}</span>
        </div>
    </div>
    <i class="fa fa-times close"></i>
    <div class="progress  active"></div>
</div>
@endif

<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Add Company</div>

        <div class="form_wrapper">
            <form action="{{ route('company.store') }}" method="POST" id="companyForm" enctype="multipart/form-data">
                <div class="subtitle mt-5 mb-5">Company Details</div>
                @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}" width="12"> </label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ asset('images/userr.png')}});">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Company Name <span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="text" name="company_name" value="{{ old('company_name') }}" id="add_company_name"
                                    placeholder="Enter your company name" autocomplete="off" />
                                </div>
                                @if ($errors->has('company_name'))
                                <span class="text-danger text-left">{{ $errors->first('company_name') }}</span>
                                @endif
                        </div>

                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Company Email <span class="reqText">*</span></label>
                            <input type="email" name="company_email" id="add_company_email" value="{{ old('company_email') }}"
                            placeholder="Enter your company email" autocomplete="off" />
                            @if ($errors->has('company_email'))
                            <span class="text-danger text-left">{{ $errors->first('company_email') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Phone number <span class="reqText">*</span></label>
                            <input type="tel" class="form-control valid" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter your company phone number"
                            minlength="10" maxlength="10" id="add_phone_number" autocomplete="off" />
                            @if ($errors->has('phone_number'))
                            <span class="text-danger text-left">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Company License <span class="reqText">*</span></label>
                            <select name="license_by" id="add_license_by">
                                <option value="company"> Company License Year </option>
                                <option value="user">Nuber of User</option>
                            </select>
                            @if ($errors->has('add_license_by'))
                            <span class="text-danger text-left">{{ $errors->first('add_license_by') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4 change_license">
                        <div class="input_grp">
                            <label for="">Company License From Year <span class="reqText"></span></label>
                        <input type="text" class="form-control datepicker"
                            name="license_by_year_from" />
                            @if ($errors->has('license_by_year_from'))
                            <span class="text-danger text-left">{{ $errors->first('license_by_year_from') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4 change_license">
                        <div class="input_grp">
                            <label for="">Company License To Year <span
                                class="reqText"></span></label>
                        <input type="text" class="form-control datepicker1"
                            name="license_by_year_to" />
                            @if ($errors->has('license_by_year_to'))
                            <span class="text-danger text-left">{{ $errors->first('license_by_year_to') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-8 licence_by_user" style="display: none;">
                        <div class="input_grp">
                            <label for="">Company License User <span class="reqText"></span></label>
                            <input type="tel" class="form-control valid" name="license_by_user" placeholder="Company License User"
                            minlength="1" maxlength="5" id="license_by_user" aria-invalid="false">

                            @if ($errors->has('license_by_user'))
                            <span class="text-danger text-left">{{ $errors->first('license_by_user') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Website<span class="reqText">*</span></label>
                            <input type="text" name="website" value="{{ old('website') }}" id="add_comapny_website"
                            placeholder="Enter your company website" autocomplete="off" />
                            @if ($errors->has('website'))
                            <span class="text-danger text-left">{{ $errors->first('website') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Address <span class="reqText">*</span></label>
                            <textarea rows="4" cols="50" type="text" name="address" value="{{ old('address') }}" id="add_address"
                                placeholder="Enter your company address" class="form-control"></textarea>
                                @if ($errors->has('address'))
                                <span class="text-danger text-left">{{ $errors->first('address') }}</span>
                                @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Country<span class="reqText">*</span></label>
                            <select name="country_id" class="country">
                                <option value="" selected>Please select country</option>
                                @foreach ($country as $vs)
                                    <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                            <span class="text-danger text-left">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">State<span class="reqText">*</span></label>
                            <select name="state_id" class="state">
                            </select>
                            @if ($errors->has('state_id'))
                            <span class="text-danger text-left">{{ $errors->first('state_id') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">City<span class="reqText">*</span></label>
                            <select name="city_id" class="city"></select>
                            @if ($errors->has('city_id'))
                            <span class="text-danger text-left">{{ $errors->first('city_id') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Pincode <span class="reqText">*</span></label>
                            <input type="tel" name="pin_code" id="add_company_pin_code"
                                placeholder="Enter your company pincode" minlength="1" maxlength="6" autocomplete="off" />

                                @if ($errors->has('pin_code'))
                                <span class="text-danger text-left">{{ $errors->first('pin_code') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Timezone<span class="reqText">*</span></label>
                            <select name="timezone_id" class="timezone">
                                <option value="" selected>Please select timezone</option>
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone->id }}">{{ $timezone->timezone }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('timezone_id'))
                            <span class="text-danger text-left">{{ $errors->first('timezone_id') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <img id="company-image-add" src="#" style="display: none" />
                        </div>
                        <!-- ./input_grp -->
                    </div>
                </div>
                <!-- ./row -->

                <div class="admin-company-email">
                    <div class="subtitle mt-5 mb-5">Account Details ( First company admin )</div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Name <span class="reqText">*</span></label>
                                <div class="add_input_option">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Enter admin name" autocomplete="off" />
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Email ( Login details will be emailed to this email )  <span class="reqText">*</span></label>
                                <div class="add_input_option">
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter admin email" autocomplete="off" />
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <!-- ./input_grp -->
                        </div>
                    </div>
                </div>

                <div class="button_flex">
                    <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                        Reset
                    </button>
                    <button type="submit" class="btn_style">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- container -->
</main>
@endsection
@push('scripts')
<script>

		//called when key is pressed in textbox
		$("#license_by_user").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 5 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});
        $("#add_phone_number").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 10 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});
        $("#add_company_pin_code").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 6 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});


        $(".image-box").click(function (event) {
            var previewImg = $(this).children("img");

            $(this).siblings().children("input").trigger("click");

            $(this)
                .siblings()
                .children("input")
                .change(function () {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var urll = e.target.result;
                        $(previewImg).attr("src", urll);
                        previewImg.parent().css("background", "transparent");
                        previewImg.show();
                        previewImg.siblings("p").hide();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
        });

        $('#add_license_by').on('change', function() {
            if (this.value == 'user') {
                $('.change_license').css('display','none')
                $('.licence_by_user').css('display','block')
            } else {
                $('.change_license').css('display','block')
                $('.licence_by_user').css('display','none')
            }
        });

        $(".datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
        $(".datepicker1").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $(document).ready(function () {
            $('.country').on('change', function () {

                var idCountry = this.value;

                $(".state").html('');
                $.ajax({
                    url: "{{url('states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('.state').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function (key, value) {
                            $(".state").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('.city').html('<option value="">-- Select City --</option>');
                    }
                });
            });

            $('.state').on('change', function () {
                var idState = this.value;
                $(".city").html('');
                $.ajax({
                    url: "{{url('cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('.city').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function (key, value) {
                            $(".city").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });
</script>
@endpush