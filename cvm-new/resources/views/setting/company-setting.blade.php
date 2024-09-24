@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')
    <section class="inner__wrapper">
            <form id="company-setting-form" name="company-setting-form" enctype="multipart/form-data" method="POST">
                @method('patch')
                @csrf
            <div class="row">
                <div class="col-sm-2">
                    <div class="input_grp">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="employee_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}" width="12"> </label>
                            </div>
                            <div class="avatar-preview">
                            @if (!empty(($company->getCompanyLogo)))
                            <div id="imagePreview" style="background-image: url({{ asset('images/company') }}/{{$company->getCompanyLogo->logo}});">
                            @else
                            <div id="imagePreview" style="background-image: url({{ asset('images/userr.png')}});">
                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7"></div>
                <input type="hidden" name="company_id" id="company_id" value="{{ $company->id}}">
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Email <span class="reqText">*</span></label>
                        <input type="email" name="email" id="add_company_email" value="{{ $company->email}}"
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
                        <input type="tel" class="form-control valid" name="phone_number" value="{{ $company->phone_number}}" placeholder="Enter your company phone number"
                        minlength="10" maxlength="10" id="add_phone_number" autocomplete="off" />
                        @if ($errors->has('phone_number'))
                        <span class="text-danger text-left">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>
                    <!-- ./input_grp -->
                </div>
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Website<span class="reqText">*</span></label>
                        <input type="text" name="website" value="{{ $company->website}}" id="add_comapny_website"
                        placeholder="Enter your company website" autocomplete="off" />
                        @if ($errors->has('website'))
                        <span class="text-danger text-left">{{ $errors->first('website') }}</span>
                        @endif
                    </div>
                    <!-- ./input_grp -->
                </div>
                <div class="col-4">
                    <div class="input_grp">
                        <label for="">Employee Prefix <span class="text-danger">*</span></label>
                        <input value="{{ $company->getCompanySetting->prefix}}" type="text" id="prefix" class="form-control" name="prefix" placeholder="prefix">
                    </div>
                </div>
                <div class="col-4">
                    <div class="input_grp">
                        <label for="">Employee Id Separator</label>
                        <input value="{{ $company->getCompanySetting->separator}}" type="text" id="separator" class="form-control" name="separator" placeholder="separator">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <button type="submit" id="company-setting-button" class="btn_style">Save</button>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection

@push('scripts')

<script>
$("#company-setting-form").validate({

rules: {
  email: {
    required: true,
  },
  phone_number: {
    required: true,
  },
  website: {
    required: true,
  },
},
messages: {

  email: {
    required: "Please enter email",
  },
  phone_number: {
    required: "Please enter phone number",
  },
  website: {
    required: "Please enter website",
  },
},

})

      $("#company-setting-form").submit(function(e) {
        if($("#company-setting-form").valid()){
        e.preventDefault();
        const fd = new FormData(this);
        var id = $('#company_id').val();
        var url = '{{ route("company-setting.update", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
          url:url,
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            console.log(response.logo);
            $('#res_message').fadeIn().html(
              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
            setTimeout(function(){
                $('#res_message').fadeIn().fadeOut();
                $('.category_datatable').DataTable().ajax.reload();
            }, 4000);

            // $(".profile_img").html(
            //   `<img src="${response.logo ? response.logo :'userr.png' }" alt="" />`);
            }
        });
    }
      });




    $("#add_phone_number").keypress(function (e) {
			if (e.which != 10 && e.which != 0 && (e.which < 48 || e.which > 57)) {
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
</script>
@endpush
