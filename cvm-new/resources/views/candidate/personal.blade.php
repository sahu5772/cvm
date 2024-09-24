<div class="tab-pane fade" id="pills-personal" role="tabpanel" aria-labelledby="pills-personal-tab">
    <main class="addCandidate_wrapper">
        <div class="container">
            <div class="title">{{ __('messages.candidate.personal_details')}}</div>

            <div class="form_wrapper">
                <form id="submitPersonalForm" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="input_grp">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type="file" name="profile_image" id="imageUpload"
                                            accept=".png, .jpg, .jpeg"
                                            value="{{asset('images/candidate/' . $candidate->profile_image)}}" />
                                        <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}"
                                                width="12" />
                                        </label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview"
                                            style=" background-image: url('{{ ($candidate->profile_image) ?  asset('images/candidate/' . $candidate->profile_image) : asset('images/userr.png')}}');">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7"></div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.first_name')}} <span
                                        class="reqText">*</span></label>
                                <input type="text" name="first_name" value="{{$candidate->first_name}}"
                                    placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.last_name')}}</label>
                                <div class="add_input_option">
                                    <input type="text" name="last_name" value="{{$candidate->last_name}}"
                                        placeholder="type here..." />
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.email')}} <span class="reqText">*</span></label>
                                <input type="text" name="email" value="{{$candidate->email}}"
                                    placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.gender')}} <span class="reqText">*</span></label>
                                <select name="gender" id="">
                                    <option value=""> {{ __('messages.select_option')}} </option>
                                    <option value="Female" @if ($candidate->gender == 'Female') selected @endif>
                                        {{ __('messages.female')}} </option>
                                    <option value="Male" @if ($candidate->gender == 'Male') selected @endif>
                                        {{ __('messages.male')}} </option>
                                    <option value="Other" @if ($candidate->gender == 'Other') selected @endif>
                                        {{ __('messages.other')}} </option>
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.dob')}} <span class="reqText">*</span></label>
                                <div class="add_input_option">
                                    <input type="date" name="dob" value="{{$candidate->dob}}"
                                        placeholder="type here..." />
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.phone_number')}} <span class="reqText">*</span></label>
                                <input type="number" name="phone_number" value="{{$candidate->phone_number}}"
                                    placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.language')}} <span class="reqText">*</span></label>
                                <select name="language_known" id="">
                                    <option value=""> {{ __('messages.select_option')}} </option>
                                    @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" @if ($candidate->language_known ==
                                        $language->id) selected @endif> {{ $language->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.father_name')}}</label>
                                <input type="text" name="father_name" value="{{$candidate->father_name}}"
                                    placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.mother_name')}} </label>
                                <input type="text" name="mother_name" value="{{$candidate->mother_name}}"
                                    placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.aadhar_card')}}</label>
                                <div class="add_input_option">
                                    <input type="text" name="aadhar_card" value="{{$candidate->aadhar_card}}"
                                        placeholder="type here..." />
                                    @error('aadhar_card')
                                    <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.pan_card')}} </label>
                                <div class="add_input_option">
                                    <input type="text" name="pan_card" value="{{$candidate->pan_card}}"
                                        placeholder="type here..." />
                                    @error('pan_card')
                                    <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.nationality')}}<span class="reqText">*</span></label>
                                <select name="country_id" id="">
                                    <option value="">{{ __('messages.select_option')}}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id}}" @if ( $candidate->country_id == $country->id)
                                        selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.designation')}}<span class="reqText">*</span></label>
                                <select name="designation_id" id="">
                                    <option value="">{{ __('messages.select_option')}}</option>
                                    @foreach ($designations as $designation)
                                    <option value="{{ $designation->id}}" @if ( $candidate->designation_id ==
                                        $designation->id) selected @endif>{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.department')}}<span class="reqText">*</span></label>
                                <select name="department_id" id="">
                                    <option value="">{{ __('messages.select_option')}}</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id}}" @if ( $candidate->department_id ==
                                        $department->id) selected @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                    </div>
                    <!-- ./row -->
                    <div class="button_flex">
                        <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                            {{ __('messages.reset')}} </button>
                        <button type="submit" id="submitPersonalButton" class="btn_style">
                            {{ __('messages.submit')}} </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- container -->
    </main>
</div>
@push('scripts')
<script>
if ($("#submitPersonalForm").length > 0) {

    $("#submitPersonalForm").validate({

        rules: {
            first_name: {
                required: true,
                maxlength: 50
            },
            gender: {
                required: true,
            },
            email: {
                required: true,
            },
            dob: {
                required: true,
            },
            phone_number: {
                required: true,
            },
            language_known: {
                required: true,
            },
            country_id: {
                required: true,
            },
            designation_id: {
                required: true,
            },
            department_id: {
                required: true,
            },
        },
    });
}

///

$("#submitPersonalForm").submit(function(e) {
    if($("#submitPersonalForm").valid()){
    e.preventDefault();
    $(document).find("span.text-danger").remove();

    var id = {{$candidate->id}};
    var url = '{{ route("candidate.update", ":id") }}';
    url = url.replace(':id', id);
    const fd = new FormData(this);
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
        $('#res_message').fadeIn().html(
            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
            response.message +
            '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
        );
        setTimeout(function() {
            $('#res_message').fadeIn().fadeOut();
        }, 4000);
        },
        error: function (xhr) {
            var errors = JSON.parse(xhr.responseText);

            $.each(errors, function(key,value) {
                $.each(value,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger" style="position:absolute;margin:50px;">' +error[0]+ '</span>')
                    })
            });
            },

        });
    }
      });
</script>
@endpush