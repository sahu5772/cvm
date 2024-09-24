@extends('layouts.app')
@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Update Company</div>

        <div class="form_wrapper">

            <form action="{{ route('company.update',$company->id) }}" id="companyFormEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="logo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}" width="12"> </label>
                                </div>
                                <div class="avatar-preview">
                                    @if (isset($company_logo))
                                    <div id="imagePreview" style="background-image: url({{ asset('images/company') }}/{{$company_logo->logo}});">
                                    @else
                                    <div id="imagePreview" style="background-image: url({{ asset('images/userr.png')}});">
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7"></div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Name <span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="text" name="name" value="{{ $company->name }}" id="add_company_name"
                                    placeholder="Enter your company name" autocomplete="off" />
                                    @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                    @endif
                            </div>
                        </div>

                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Email <span class="reqText">*</span></label>
                            <input type="text" name="email" id="add_company_email" value="{{ $company->email }}"
                            placeholder="Enter your company email" autocomplete="off" />
                            @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Phone number <span class="reqText">*</span></label>
                            <input type="tel" class="form-control valid" name="phone_number" placeholder="Enter your company phone number"
                            minlength="10" maxlength="10" id="add_phone_number" autocomplete="off" value="{{ $company->phone_number }}"/>
                            @if ($errors->has('phone_number'))
                            <span class="text-danger text-left">{{ $errors->first('phone_number') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>



                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Company License By User <span class="reqText">*</span></label>
                            <select name="license_by" id="add_license_by">
                                <option value="company" @if($company_license->license_by == 'company') selected @endif> Company License Year </option>
                                <option value="user" @if($company_license->license_by == 'user') selected @endif>Nuber of User</option>
                            </select>
                            @if ($errors->has('license_by'))
                            <span class="text-danger text-left">{{ $errors->first('license_by') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4 change_license" @if($company_license->license_by == 'company') style="display: block;" @else style="display: none;" @endif>
                        <div class="input_grp">
                            <label for="">Company License From Year <span
                                class="reqText">*</span></label>
                        <input type="text" class="form-control datepicker"
                            name="license_by_year_from"  value="{{ $company_license->license_by_year_from }}"/>
                        </div>
                    </div>
                    <div class="col-sm-4 change_license" @if($company_license->license_by == 'company') style="display: block;" @else style="display: none;" @endif>
                        <div class="input_grp">
                            <label for="">Company License To Year <span
                                class="reqText">*</span></label>
                            <input type="text" class="form-control datepicker"
                            name="license_by_year_to" value="{{ $company_license->license_by_year_to }}"/>
                        </div>
                    </div>
                    <div class="col-sm-8 licence_by_user" @if($company_license->license_by == 'user') style="display: block;" @else style="display: none;" @endif>
                        <div class="input_grp">
                            <label for="">Company License User <span class="reqText">*</span></label>
                            <input type="tel" class="form-control valid" name="license_by_user" placeholder="Company License User"
                            minlength="1" maxlength="5" id="license_by_user" aria-invalid="false" value="{{$company_license->license_by_user}}">

                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Website<span class="reqText">*</span></label>
                            <input type="text" name="website" id="add_comapny_website"
                            placeholder="Enter your company website" autocomplete="off" value="{{ $company->website }}"/>
                            @if ($errors->has('website'))
                            <span class="text-danger text-left">{{ $errors->first('website') }}</span>
                            @endif
                        </div>
                        <!-- ./input_grp -->
                    </div>

                </div>
                <!-- ./row -->

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

@push('scripts')
<script>

		//called when key is pressed in textbox
		$("#license_by_user").keypress(function (e) {
            // alert(e.which);
			//if the letter is not digit then display error and don't type anything
			if (e.which != 5 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});
        $("#add_phone_number").keypress(function (e) {
            // alert(e.which);
			//if the letter is not digit then display error and don't type anything
			if (e.which != 10 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});
        $("#add_company_pin_code").keypress(function (e) {
            // alert(e.which);
			//if the letter is not digit then display error and don't type anything
			if (e.which != 6 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   return false;
			}
		});

if ($("#companyFormEdit").length > 0) {
            $("#companyFormEdit").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                    },
                    phone_number: {
                        required: true,
                        number: true
                    },
                    website: {
                        required: true,
                    },
                    pin_code: {
                        required: true,
                        number: true,

                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter name",
                    },
                    email: {
                        required: "Please enter email",
                    },
                    phone_number: {
                        required: "Please enter phone number",
                    },
                    address: {
                        required: "Please enter address",
                    },
                    website: {
                        required: "Please enter website name",
                    },
                    pin_code: {
                        required: "Please enter pincode",
                    },
                },
            })
        }


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
@endsection