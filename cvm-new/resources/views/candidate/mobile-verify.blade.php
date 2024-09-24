<div class="close-button">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span>
    </button>
  </div>
  {{-- <form> --}}
  <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="phone-verifief-img">
            <img src="{{ asset('images/icons/check.png')}}" alt="" width="90">
          </div>
          <div class="phone-otp-cont">
            <span>Verify Your Mobile Number</span>
            <p>A 6-digit code has been send to </p>
            <p class="mobile-no">{{$candidate->phone_number}}</p>
            <div class="otp-container">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
              <input type="text" class="otp-input mobile-otp" pattern="\d" maxlength="1">
            </div>
            <div class="otp-mobile text-danger"></div>
            <div class="resend-div">
              <span>Didn't Receive the Code?<a href="#" onclick="resendOtp({{$candidate->id}})">Resend</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn_style" onclick="submitOtp({{$candidate->id}})">Submit</button>
    </div>
{{-- </form> --}}