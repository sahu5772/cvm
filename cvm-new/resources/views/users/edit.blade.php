@extends('layouts.app')

@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Edit Employee</div>

        <div class="form_wrapper">
            <form action="{{ route('users.update', $user->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="employee_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"><img src="{{ asset('images/icons/upload.png')}}" width="12"> </label>
                                </div>
                                <div class="avatar-preview">
                                @if (!empty(($user->profile_picture)))
                                <div id="imagePreview" style="background-image: url({{ asset('images/employee') }}/{{$user->profile_picture}});">
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
                            <label for="">Employee Id <span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="employee_id" value="{{ $user->employee_id}}" placeholder="type here..." />
                            </div>
                            @error('employee_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Name <span class="reqText">*</span></label>
                            <input type="text" name="name"  value="{{ $user->name}}" placeholder="Enter name" />
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Email <span class="reqText">*</span></label>
                            <input type="email" name="email" value="{{ $user->email}}" placeholder="type here..." />
                            @error('email')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
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
                            <label for="">Designation<span class="reqText">*</span></label>
                            <select name="designation" id="">
                                <option value="">Select option</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" @if ($designation->id == $user->designation_id )
                                        selected
                                    @endif>{{ ucfirst($designation->name) }}</option>
                                @endforeach
                            </select>
                            @error('designation')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            @if (auth()->user()->hasAnyRole(['system-admin', 'super-admin']))
                                <label for="">Business Unit<span class="reqText">*</span></label>
                                <select name="business_unit">
                                    <option value="">Select business unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" @if ($unit->id == $user->business_unit_id )
                                            selected
                                        @endif>{{ ucfirst($unit->name) }}</option>
                                    @endforeach
                                </select>
                                @error('business_unit')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            @else
                            <input type="hidden" name ="business_unit" value="{{Auth::user()->business_unit_id}}" />
                            @endif

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Department<span class="reqText">*</span></label>
                            <select name="department" id="">
                                <option value="" selected>Select option</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @if ($department->id == $user->department_id)
                                        selected
                                    @endif>{{ ucfirst($department->name) }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
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
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Date of Joining <span class="reqText">*</span></label>
                            <input type="date" name="joining_date"  value="{{ $user->joining_date}}" placeholder="type here..." />
                            @error('joining_date')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Reporting to<span class="reqText">*</span></label>
                            <select name="user" id="">
                                <option value="">Select option</option>
                                @foreach($reporting as $reportings)
                                    <option value="{{ $reportings->id }}" @if ($user->id == $reportings->id) selected @endif>{{ ucfirst($reportings->name) }}</option>
                                @endforeach
                            </select>
                            @error('user')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            @if (auth()->user()->hasAnyRole(['system-admin', 'super-admin']))
                                <label for="">User Role<span class="reqText">*</span></label>
                                <select name="role" id="">
                                <option value="">Select option</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" @if ($currentRole == $role->name) selected @endif>{{ ucfirst($role->name) }}</option>
                                @endforeach
                                @error('role')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </select>
                            @else
                            @if (!empty($currentRole))
                                <input name="role" type="hidden" value="{{ $currentRole }}" />
                            @else
                                <input name="role" type="hidden" value="employee" />
                            @endif
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