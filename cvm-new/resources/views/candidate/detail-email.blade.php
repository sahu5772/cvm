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
<form id="verifyEmailForm" name="verifyEmailForm" class="form-horizontal" method="POST">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
            <div class="phone-verifief-img">
                <img src="{{ asset('images/icons/mail.png')}}" alt="" width="90">
            </div>
            <div class="phone-otp-cont">
                <span>Enter Email</span>
                <input type="hidden" name="candidate_id" value="{{$id}}">
                <div class="input_grp">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" />
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-save" class="btn_style" onclick="sendDetail({{$id}})">Send Mail</button>
    </div>
</form>