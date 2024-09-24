@extends('layouts.app')
@section('content')
<main class="master__wrapper">
  @include('layouts.sidemenu')
  <!-- ./side__menu -->
  <section class="inner__wrapper email-wrapper">
    <div class="title">Email Setting</div>
    <div class="row">
      <div class="col-8">
        <div class="container">
          <form id="company-setting-form" method="POST" action="{{route('emailSetting.save')}}">
            @csrf
            <div class="row">
                <input type="hidden" name="id" id="id" value="{{ (!empty($setting)) ? $setting->id :'' }}">
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail Host<span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_host : old('mail_host') }}" type="text" class="form-control" name="mail_host" placeholder="Mail Host">
                        @if ($errors->has('mail_host'))
                        <span class="text-danger text-left">{{ $errors->first('mail_host') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail Port<span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_port : old('mail_port') }}" type="number" class="form-control" name="mail_port" placeholder="Mail Port">
                        @if ($errors->has('mail_port'))
                        <span class="text-danger text-left">{{ $errors->first('mail_port') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail Username<span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_username : old('mail_username') }}" type="text" class="form-control" name="mail_username" placeholder="Mail Username" autocomplete="off">
                        @if ($errors->has('mail_username'))
                        <span class="text-danger text-left">{{ $errors->first('mail_username') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail Password<span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_password : old('mail_password') }}" type="password" class="form-control" name="mail_password" placeholder="Mail Password" autocomplete="off">
                        @if ($errors->has('mail_password'))
                        <span class="text-danger text-left">{{ $errors->first('mail_password') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail From Name <span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_from_name : old('mail_from_name') }}" type="text" class="form-control" name="mail_from_name" placeholder="Mail From Name">
                        @if ($errors->has('mail_from_name'))
                        <span class="text-danger text-left">{{ $errors->first('mail_from_name') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail From Email<span class="text-danger">*</span></label>
                        <input value="{{ (!empty($setting)) ? $setting->mail_from_email : old('mail_from_email') }}" type="email" class="form-control" name="mail_from_email" placeholder="Mail From Email">
                        @if ($errors->has('mail_from_email'))
                        <span class="text-danger text-left">{{ $errors->first('mail_from_email') }}</span>
                         @endif
                    </div>
                </div>
                <div class="col-10">
                    <div class="input_grp">
                        <label for="">Mail Encryption</label>
                        <select class="form-control form-control-lg" name="mail_encryption" id="mail_encryption">
                            <option value="tls" {{ (!empty($setting)) ? $setting->mail_encryption == 'tls' ? 'selected' :'' : old('mail_encryption') }}>
                            tls
                            </option>
                            <option value="ssl"{{ (!empty($setting)) ? $setting->mail_encryption == 'ssl' ? 'selected' :'' : old('mail_encryption') }}>
                            ssl
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="button_flex">
                <button type="submit" class="btn_style">Save</button>
                <button id="send-test-email" type="button" data-target="#editModal" data-toggle="modal" aria-expanded="false" class="btn_style" ><i class="fa fa-envelope"></i> Send Test Mail</button>
            </div>
        </form>
        </div>
      </div>
      <div class="col-4">
        <div class="email-toggle-options">
          <span>Email Notification Settings</span>
          <form>
            @foreach ($notifications as $notifications)
            <div class="form-group">
              <input type="checkbox" id="form-{{$notifications->id}}" class="notifications" value="{{$notifications->id}}" @if($notifications->is_active == 'Active') checked @endif>
              <label for="form-{{$notifications->id}}">{{ucfirst($notifications->title)}}</label>
            </div>
            @endforeach
          </form>
        </div>
      </div>
    </div>
    <!-- ./row -->
  </section>
</main>

<div
class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static"
>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Test Email</h5>
      <button
        type="button"
        class="close"
        data-dismiss="modal"
        aria-label="Close"
      >
        <span aria-hidden="true">
          <svg
            width="16"
            height="16"
            viewBox="0 0 22 22"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M18 6L6 18"
              stroke="black"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M6 6L18 18"
              stroke="black"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </span>
      </button>
    </div>
      <form id="testEmailSend" name="testEmailSend" class="form-horizontal" method="POST">
    <div class="modal-body">
            @csrf
        <div class="row">
          <div class="col-sm-12">
            <div class="input_grp">
              <label for="">Title <span class="reqText">*</span></label>
              <input type="text" name="title" id="title" placeholder="enter title "/>
            </div>
            <div class="input_grp">
              <label for=""
                >Enter email address where test mail needs to be sent <span class="reqText">*</span></label>
              <input type="email" name="sendEmail" id="sendEmail" placeholder="enter your test mail" />
            </div>
            <div class="input_grp">
              <label for=""
                >Message <span class="reqText">*</span></label
              >
              <input type="text" name="message" id="message" placeholder="enter your message" />
            </div>
            <!-- ./input_grp -->
          </div>
        </div>
        <!-- ./row -->
    </div>
    <div class="modal-footer">
      <button
        type="button"
        class="btn_style ghost_btn"
        data-dismiss="modal"
      >
        Close
      </button>
      <button type="submit" class="btn_style">Save changes</button>
    </div>
</form>
  </div>
</div>
</div>
@endsection
@push('scripts')
<script>
  // function notificationData(id){
  //   alert(id);
  // }

  $(".notifications").on("click", function (e) {
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var notification = '';
      var status = '';
      if ($(this).is(':checked')) {
         notification = $(this).val();
         status = 'Active';
      } else {
         notification = $(this).val();
         status = 'Inactive';
      }
      $.ajax({
        url: '{{ route('email-notification') }}',
        type: "POST",
        data: {notification:notification,status:status},
        success: function( response ) {
          $('#res_message').fadeIn().html(
              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
            setTimeout(function(){
                $('#res_message').fadeIn().fadeOut();

            }, 4000);
        },
        error: function (data) {
              console.log('Error:', data);
          }
      });

  });

   if ($("#testEmailSend").length > 0) {

    $("#testEmailSend").validate({
      rules: {
                sendEmail: {
                    required: true,
                },
                title: {
                    required: true,
                },
                message: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: "Please enter a title",
                },
                message: {
                    required: "Please enter a message",
                },
                sendEmail: {
                    required: "Please enter a email",
                },
            },
    submitHandler: function(form) {
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: '{{ route('sendEmail.store') }}',
        type: "POST",
        data: $('#testEmailSend').serialize(),
        success: function( response ) {
            $('#testEmailSend').trigger("reset");
            $('#res_message').fadeIn().html(
              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
            $('#editModal').modal('hide');
            setTimeout(function(){
                $('#res_message').fadeIn().fadeOut();

            }, 4000);
        },
        error: function (data) {
              console.log('Error:', data);
          }
      });
    }
  })
}
</script>

@endpush


