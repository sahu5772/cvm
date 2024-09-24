@extends('layouts.app')

@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Add Business Unit</div>

        <div class="form_wrapper">
            <form action="{{ route('business.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Name <span class="reqText">*</span></label>
                            <input type="text" name="name" value="{{old('name')}}" placeholder="Enter name" />
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Phone Number <span class="reqText">*</span></label>
                            <input type="number" name="phone_number" value="{{ old('phone_number') }}" placeholder="type here..." />
                            @error('phone_number')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Address <span class="reqText">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="type here..." />
                            @error('address')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Country<span class="reqText">*</span></label>
                            <select name="country_id" class="country">
                                <option value="">Select Option</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{ ucfirst($country->name)}}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
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
                            <input type="number" name="pin_code" value="{{ old('pin_code') }}" placeholder="type here..." />
                            @error('pin_code')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Timezone <span class="reqText">*</span></label>
                            <select name="timezone_id">
                                <option value="">Select Option</option>
                                @foreach ($timezones as $timezone)
                                    <option value="{{$timezone->id}}">{{ ucfirst($timezone->timezone)}}</option>
                                @endforeach
                            </select>
                            @error('timezone_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
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
@endsection
@push('scripts')
    <script>
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