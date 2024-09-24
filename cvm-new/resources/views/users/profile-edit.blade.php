@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')
    <section class="inner__wrapper">
        <form id="profile-setting-form" name="profile-setting-form" enctype="multipart/form-data" method="POST">
            @method('post')
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $user->id}}"/>
            <div class="row">
                <div class="col-sm-2">
                    <div class="input_grp">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" name="profile_picture" id="imageUpload"
                                    accept=".png, .jpg, .jpeg"
                                    />
                                <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}"
                                        width="12" />
                                </label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview"
                                    style=" background-image: url('{{ ($user->profile_picture) ?  asset('images/employee/' . $user->profile_picture) : asset('images/userr.png')}}');">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">
                            Upload Picture <span class="reqText">*</span></label>
                        <div class="control-group file-upload" id="file-upload1">
                            <div class="image-box text-center">
                                @if (!empty(($user->profile_picture)))
                                <img style="width: 120px;" src="{{ asset('images/employee') }}/{{$user->profile_picture}}" class="upload_img"/>
                                @else

                                    <img style="width: 120px;" src="{{ asset('images/icons/upload.png') }}" />
                                @endif
                            </div>
                            <div class="controls" style="display: none">
                                <input name="profile_picture" id="logo" type="file" class="form-control">
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-sm-8"></div>
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Name <span class="reqText">*</span></label>
                        <input type="text" name="name" id="name" value="{{ $user->name}}"
                        placeholder="Enter your name" autocomplete="off" />
                        @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Email <span class="reqText">*</span></label>
                        <input type="email" name="email" id="email" value="{{ $user->email}}"
                        placeholder="Enter your email" autocomplete="off" />
                        @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                </div>
                @if (auth()->user()->hasAnyRole(['system-admin', 'super-admin']))
                <div class="col-sm-4">
                    <div class="input_grp" id="input_grp">
                        <label for="">Password <span class="reqText">*</span></label>
                        <input type="password" name="password" id="password" value="" placeholder="Enter your password" autocomplete="off" />
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="col-sm-4">
                    <div class="filter-search-input">
                        <div class="form_wrapper">
                            <div class="input_grp">
                                <span>Email Notification</span>
                                <div class="radio-container" style="display: flex">
                                    <div class="radio">
                                        <input id="radio-1" name="email_notification" class="email_notification" type="radio" value="Enable" {{ $user->email_notification == 'Enable' ? 'checked' : '' }}>
                                        <label for="radio-1" class="radio-label">Enable</label>
                                    </div>
                                    <div class="radio">
                                        <input id="radio-2" name="email_notification" class="email_notification" type="radio" value="Disable" {{ $user->email_notification == 'Disable' ? 'checked' : '' }}>
                                        <label for="radio-2" class="radio-label">Disable</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Date of Birth <span class="reqText">*</span></label>
                        <input type="date" name="dob"  value="{{ $user->dob}}" placeholder="type here..." />
                        @error('dob')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- ./input_grp -->
                </div>
                <div class="col-sm-4">
                    <div class="input_grp">
                        <label for="">Gender<span class="reqText">*</span></label>
                        <select name="gender" id="">
                            <option value="Male" @if ($user->gender == 'Male') selected @endif>Male</option>
                            <option value="Female" @if ($user->gender == 'Female') selected @endif>Female</option>
                            <option value="Other" @if ($user->gender == 'Other') selected @endif>Other</option>
                        </select>
                        @error('gender')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
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
$("#profile-setting-form").validate({
  rules: {
    name: {
      required: true,
    },
    email: {
      required: true,
      email: true,
    },
    dob: {
      required: true,
    },
    gender: {
      required: true,
    },
  },
  messages: {
    name: {
      required: "Please enter your name",
    },
    email: {
      required: "Please enter your email",
      email: "Please enter a valid email address",
    },
    dob: {
      required: "Please enter your date of birth",
    },
    gender: {
      required: "Please select your gender",
    },
  },
});
$("#profile-setting-form").submit(function(e) {
    if($("#profile-setting-form").valid()){
    e.preventDefault();
    $(document).find("span.text-danger").remove();
    const fd = new FormData(this);
    var url = '{{ route("users.profile-settings") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: fd,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $(".profile_img").html(
                `<img src="${response.logo ? response.logo :'userr.png' }" alt="" />`);
            $('#res_message').fadeIn().html(
                '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                    + response.message + '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
            setTimeout(function() {
                $('#res_message').fadeIn().fadeOut();
                $('#password').val("");
            }, 4000);
        },
        error: function (xhr) {
            $('#validation-errors').html('');
            var errors = JSON.parse(xhr.responseText);

            $.each(errors, function(key,value) {
                $.each(value,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error[0]+ '</span>')
                    })
            });
            },

        });
    }
      });

</script>
@endpush
