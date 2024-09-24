@extends('layouts.app')

@section('content')
    <main class="addCandidate_wrapper">
        <div class="container">
            <div class="title">{{ __('messages.add')}} {{ __('messages.candidate.candidate')}}</div>

            <div class="form_wrapper">
                <form action="{{ route('candidate.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="input_grp">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="profile_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
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
                                <label for="">{{ __('messages.candidate.first_name')}} <span class="reqText">*</span></label>
                                <div class="add_input_option">
                                    <input type="text" name="first_name" value="{{ old('first_name')}}" placeholder="type here..." />
                                </div>
                                @error('first_name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.last_name')}} </label>
                                <div class="add_input_option">
                                    <input type="text" name="last_name" value="{{ old('last_name')}}" placeholder="type here..." />
                                    @error('last_name')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.email')}} <span class="reqText">*</span></label>
                                <input type="text" name="email" value="{{ old('email')}}" placeholder="type here..." />
                                @error('email')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.gender')}}<span class="reqText">*</span></label>
                                <select name="gender" id="">
                                    <option value="">{{ __('messages.select_option')}}</option>
                                    <option value="Female">{{ __('messages.female')}}</option>
                                    <option value="Male">{{ __('messages.male')}}</option>
                                    <option value="Other">{{ __('messages.other')}}</option>
                                </select>
                                @error('gender')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.dob')}} <span class="reqText">*</span></label>
                                <div class="add_input_option">
                                    <input type="date" name="dob" value="{{ old('dob')}}" placeholder="type here..." />
                                </div>
                                @error('dob')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.phone_number')}}<span class="reqText">*</span></label>
                                <input type="number" name="phone_number" value="{{ old('number')}}" placeholder="type here..." />
                                @error('phone_number')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>

                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">{{ __('messages.language')}}<span class="reqText">*</span></label>
                                <select name="language_known" id="">
                                    <option value="">{{ __('messages.select_option')}}</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name}}</option>
                                    @endforeach
                                </select>
                                @error('language_known')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>

                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.father_name')}}</label>
                                <div class="add_input_option">
                                    <input type="text" name="father_name" value="{{ old('father_name')}}" placeholder="type here..." />
                                    @error('father_name')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>

                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.mother_name')}} </label>
                                <div class="add_input_option">
                                    <input type="text" name="mother_name" value="{{ old('mother_name')}}" placeholder="type here..." />
                                    @error('mother_name')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>

                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> {{ __('messages.candidate.aadhar_card')}}</label>
                                <div class="add_input_option">
                                    <input type="text" name="aadhar_card" value="{{ old('aadhar_card')}}" placeholder="type here..." />
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
                                    <input type="text" name="pan_card" value="{{ old('pan_card')}}" placeholder="type here..." />
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
                                        <option value="{{ $country->id}}">{{ $country->name }}</option>
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
                                        <option value="{{ $designation->id}}">{{ $designation->name }}</option>
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
                                        <option value="{{ $department->id}}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for=""> Upload CV</label>
                                <div class="add_input_option">
                                    <input type="file" name="file" value="{{ old('file')}}" />
                                    @error('file')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                    </div>
                    <!-- ./row -->

                    <div class="button_flex">
                        <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                             {{ __('messages.reset')}}
                        </button>
                        <button type="submit" class="btn_style">{{ __('messages.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- container -->
    </main>

@endsection