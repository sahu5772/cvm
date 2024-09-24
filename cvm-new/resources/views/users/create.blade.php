@extends('layouts.app')

@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Add Employee</div>

        <div class="form_wrapper">
            <form action="{{ route('users.store') }}" method="POST"  enctype="multipart/form-data">
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
                                    <div id="imagePreview" style="background-image: url({{ asset('images/userr.png')}});">
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
                                <input type="number" name="employee_id" value="{{ old('employee_id')}}" placeholder="type here..." />

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
                            <input type="text" name="name" value="{{old('name')}}" placeholder="Enter name" />
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Email <span class="reqText">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="type here..." />
                            @error('email')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- ./input_grp -->
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Date of Birth <span class="reqText">*</span></label>
                            <input type="date" name="dob" value="{{ old('dob') }}" placeholder="type here..." />
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
                                <option value="" selected>Select option</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}">{{ ucfirst($designation->name) }}</option>
                                @endforeach
                            </select>
                            @error('designation')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Department<span class="reqText">*</span></label>
                            <select name="department" id="">
                                <option value="" selected>Select option</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ ucfirst($department->name) }}</option>
                                @endforeach
                            </select>
                            @error('department')
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
                                        <option value="{{ $unit->id }}">{{ ucfirst($unit->name) }}</option>
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
                            <label for="">Gender<span class="reqText">*</span></label>
                            <select name="gender" id="">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Date of Joining <span class="reqText">*</span></label>
                            <input type="date" name="joining_date" value="{{ old('joining_date') }}" placeholder="type here..." />
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
                                <option value="" selected>Select option</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
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
                                    @if (auth()->user()->hasRole('super-admin'))
                                        <option value="1" selected>Super Admin</option>
                                    @else
                                        <option value="2" selected>System Admin</option>
                                    @endif
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            @else
                                @foreach($roles as $role)
                                    @if ($role->name === 'employee')
                                        <input type="hidden" name ="role" value="{{ $role->id }}" />
                                    @endif
                                @endforeach
                            @endif

                        </div>
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
    $(".image-box").click(function (event) {
        var previewImg = $(this).children("img");

        $(this).siblings().children("input").trigger("click");

        $(this)
            .siblings()
            .children("input")
            .change(function () {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var url = e.target.result;
                    $(previewImg).attr("src", url);
                    previewImg.parent().css("background", "transparent");
                    previewImg.show();
                    previewImg.siblings("p").hide();
                };
                reader.readAsDataURL(this.files[0]);
            });
    });
</script>
@endpush