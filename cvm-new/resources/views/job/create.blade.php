@extends('layouts.app')
@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Add Job</div>

        <div class="form_wrapper">
            <form action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
                @csrf
                <div class="row">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job title <span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="text" name="title" value="{{ old('title') }}" id="add_job_title"
                                    placeholder="Enter your Job title" autocomplete="off" />
                            </div>
                            @if ($errors->has('title'))
                                <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job Category<span class="reqText">*</span></label>
                            <select name="job_category_id" class="job-category" value="{{ old('job_category_id') }}" id="job-category">
                                <option value="" selected>Please select Job Category</option>
                                @foreach ($jobCategory as $jobCat)
                                    <option value="{{ $jobCat->id }}">{{ $jobCat->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('job_category_id'))
                                <span class="text-danger text-left">{{ $errors->first('job_category_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job Sub Category<span class="reqText">*</span></label>
                            <select name="job_sub_category_id" class="job-sub-category" value="{{ old('job_sub_category_id') }}" id="subCategorySelect">
                                <!-- Subcategory options will be populated here -->
                            </select>
                            @if ($errors->has('job_sub_category_id'))
                                <span class="text-danger text-left">{{ $errors->first('job_sub_category_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Department<span class="reqText">*</span></label>
                            <select name="department_id" class="department" value="{{ old('department_id') }}" id="department">
                                <option value="" selected>Please select department</option>
                                @foreach ($department as $dPart)
                                    <option value="{{ $dPart->id }}">{{ $dPart->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department_id'))
                                <span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp multiSelect">
                            <label for="">Skill<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <select multiple placeholder="Choose skills" data-allow-clear="1" value="{{ old('skill_id[]') }}" name="skill_id[]" id="multiSelectSkill">
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                                <div class="addmore" data-toggle="modal" data-target="#manageRoleModal" id="skills">Add</div>
                            </div>
                        </div>
                        @if ($errors->has('skill_id'))
                            <span class="text-danger text-left">{{ $errors->first('skill_id') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp multiSelect">
                            <label for="">Job Location<span class="reqText">*</span></label>
                            <div class="add_input_option">
                            <select multiple placeholder="Choose location" data-allow-clear="1" value="{{ old('location_id[]') }}" name="location_id[]" id="multiSelectLocation">
                                @foreach ($companyLocation as $compLoc)
                                    <option value="{{ $compLoc->id }}">{{ $compLoc->name }}</option>
                                @endforeach
                            </select>
                            <div class="addmore" data-toggle="modal" onclick="unit(1)" id="locations">Add</div>
                        </div>
                            @if ($errors->has('location_id'))
                                <span class="text-danger text-left">{{ $errors->first('location_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Start Date<span class="reqText">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" />
                            @if ($errors->has('start_date'))
                                <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                            @endif
                            <div id="start_date_error" style="color: red;"></div>
                        </div>
                        <!-- ./input_grp -->
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">End Date<span class="reqText">*</span></label>
                            <input type="date" name="end_date" id="end_date" placeholder="type here..." value="{{ old('end_date') }}" />
                            @if ($errors->has('end_date'))
                                <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                            @endif
                            <div id="end_date_error" style="color: red;"></div>

                        </div>
                        <!-- ./input_grp -->
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Openings<span class="reqText"></span></label>
                            <div class="add_input_option">
                                <input type="number" name="openings" value="{{ old('openings') }}" id="add_openings"
                                    placeholder="Enter your opemimgs" autocomplete="off" />
                            @if ($errors->has('openings'))
                                <span class="text-danger text-left">{{ $errors->first('openings') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job Type<span class="reqText">*</span></label>
                            <div class="add_input_option">
                            <select name="job_type_id" class="job_type" id="job_type" value="{{ old('job_type_id') }}">
                                <option value="" selected>Please select Job Type</option>
                                @foreach ($jobTypes as $jobType)
                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                @endforeach
                            </select>
                            <div class="addmore" data-toggle="modal" id="jobtype">Add</div>
                            </div>
                            @if ($errors->has('job_type_id'))
                            <span class="text-danger text-left">{{ $errors->first('job_type_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="experience">Experience<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <div class="add_input_option">
                                    <input type="number" name="experience_years" value="{{ old('experience_years') }}" id="experience_years"
                                        placeholder="Years" autocomplete="off" />
                                </div>
                                <div class="add_input_option">
                                    <input type="number" name="experience_months" value="{{ old('experience_months') }}" id="experience_months"
                                        placeholder="Months" autocomplete="off" />
                                </div>
                            </div>
                            @if ($errors->has('experience'))
                                <span class="text-danger text-left">{{ $errors->first('experience') }}</span>
                            @endif
                            <div id="exp_error" style="color: red;"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="payment_frequency">Payment Frequency<span class="reqText"></span></label>
                            <select name="payment_frequency" class="payment_frequency" id="payment_frequency" value="{{ old('payment_frequency') }}">
                                <option value="" selected>Please select Payment Frequency</option>
                                <option value="range">Range</option>
                                <option value="starting salary">Starting Salary</option>
                                <option value="maximum salary">Maximum Salary</option>
                                <option value="exact salary">Exact Salary</option>
                            </select>
                            @if ($errors->has('payment_frequency'))
                                <span class="text-danger text-left">{{ $errors->first('payment_frequency') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4" id="minimum_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Minimum Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="minimum_salary" value="{{ old('minimum_salary') }}" id="minimum_salary"
                                    placeholder="Enter Your Minimum Salary" autocomplete="off" />
                            @if ($errors->has('minimum_salary'))
                                <span class="text-danger text-left">{{ $errors->first('minimum_salary') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="maximum_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Maximum Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="maximum_salary" value="{{ old('maximum_salary') }}" id="maximum_salary"
                                    placeholder="Enter Your Maximum Salary" autocomplete="off" />
                            @if ($errors->has('maximum_salary'))
                                <span class="text-danger text-left">{{ $errors->first('maximum_salary') }}</span>
                            @endif
                            </div>
                            <div id="salary_error" style="color: red;"></div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="starting_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Starting Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="starting_salary" value="{{ old('starting_salary') }}" id="starting_salary"
                                    placeholder="Enter Your Starting Salary" autocomplete="off" />
                            @if ($errors->has('starting_salary'))
                                <span class="text-danger text-left">{{ $errors->first('starting_salary') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="exact_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Exact Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="exact_salary" value="{{ old('exact_salary') }}" id="exact_salary"
                                    placeholder="Enter Your Exact Salary" autocomplete="off" />
                            @if ($errors->has('exact_salary'))
                                <span class="text-danger text-left">{{ $errors->first('exact_salary') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="rate_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="rate">Rate<span class="reqText">*</span></label>
                            <select name="rate" class="rate" id="rate" value="{{ old('rate') }}">
                                <option value="" selected>Please select Rate</option>
                                <option value="hour">Hourly</option>
                                <option value="day">Daily</option>
                                <option value="week">Weekly</option>
                                <option value="month">Monthly</option>
                                <option value="year">Yearly</option>
                            </select>
                            @if ($errors->has('rate'))
                                <span class="text-danger text-left">{{ $errors->first('rate') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Currecy <span class="reqText">*</span></label>
                            <select name="currency_id" class="currency_id" id="currency_id" value="{{ old('currency_id') }}">
                                <option value="" selected>Please select Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('currency_id'))
                                <span class="text-danger text-left">{{ $errors->first('currency_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Education<span class="reqText">*</span></label>
                            <div class="add_input_option">
                            <select multiple placeholder="Choose Education" data-allow-clear="1" name="educational_level_id[]" id="multiSelectEducation" value="{{ old('education_id[]') }}">
                                @foreach ($educations as $education)
                                <option value="{{ $education->id }}">{{ $education->name }}</option>
                                @endforeach
                            </select>
                            <div class="addmore" data-toggle="modal" id="edulevel">Add</div>
                            </div>
                            @if ($errors->has('educational_level_id'))
                                <span class="text-danger text-left">{{ $errors->first('educational_level_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="input_grp">
                            <label for="">Description <span class="reqText"></span></label>
                            <textarea rows="3" cols="50" type="text" name="description" id="add_description"
                                placeholder="Enter your job description" class="form-control" value="{{ old('description') }}"></textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Benefits And Perks<span class="reqText">*</span></label>
                            <select multiple placeholder="Choose Education" data-allow-clear="1" name="company_perk_id[]" id="multiSelectPerk" value="{{ old('company_perk_id[]') }}">
                                @foreach ($companyPerk as $perk)
                                    <option value="{{ $perk->id }}">{{ $perk->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('company_perk_id'))
                                <span class="text-danger text-left">{{ $errors->first('company_perk_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="industry">Industry<span class="reqText">*</span></label>
                            <select name="industry_id" class="industry" id="industry" value="{{ old('industry_id') }}">
                                <option value="" selected>Please select Industry</option>
                               @foreach ($industry as $vs)
                               <option value="{{$vs->id}}">{{$vs->name}}</option>
                               @endforeach
                            </select>
                        </div>
                        @if ($errors->has('industry_id'))
                            <span class="text-danger text-left">{{ $errors->first('industry_id') }}</span>
                        @endif
                    </div>

                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Is it a Remote Job?<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="is_remote_job" value="Yes" value="{{ old('is_remote_job') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('is_remote_job'))
                                <span class="text-danger text-left">{{ $errors->first('is_remote_job') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Disclose Salary?<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="disclose_salary" value="Yes" value="{{ old('disclose_salary') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('disclose_salary'))
                                <span class="text-danger text-left">{{ $errors->first('disclose_salary') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Photo -->
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Photo<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="photo" value="Required" value="{{ old('photo') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('photo'))
                                <span class="text-danger text-left">{{ $errors->first('photo') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Resume -->
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Upload Resume/CV<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="resume" value="Required" value="{{ old('resume') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('resume'))
                                <span class="text-danger text-left">{{ $errors->first('resume') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>

                   <!-- Date of Birth (dob) -->
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Date of Birth<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="dob" value="Required" value="{{ old('dob') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('dob'))
                                <span class="text-danger text-left">{{ $errors->first('dob') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Gender<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="gender" value="Required" value="{{ old('gender') }}" />
                                    <span class="slider"></span>
                            @if ($errors->has('gender'))
                                <span class="text-danger text-left">{{ $errors->first('gender') }}</span>
                            @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label>Show Recruiter<span class="reqText"></span></label>
                            <div class="switch_button">
                                <label class="switch">
                                    <input type="checkbox" name="show_recruiter" value="Required" value="{{ old('show_recruiter') }}" />
                                    <span class="slider"></span>
                                    @if ($errors->has('show_recruiter'))
                                        <span class="text-danger text-left">{{ $errors->first('show_recruiter') }}</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

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

@include('skills.skill')
@include('job.job-type')
@include('job.education')
@include('business.business-unit')

@push('scripts')
<script>


    $(document).ready(function () {

        $('#job-category').on('change', function () {
            var categoryId = $(this).val();
            if (categoryId !== '') {
                $.ajax({
                    url: '{{ route('getSubcategories', ['id' => 'categoryId']) }}'.replace('categoryId', categoryId),
                    type: 'GET',
                    success: function(response) {
                        $('#subCategorySelect').html('<option selected="selected">Choose Sub Category...</option>');
                        $.each(response, function(key, value) {
                            $('#subCategorySelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subCategorySelect').html('<option selected="selected">Choose Sub Category...</option>');
            }
        });
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
<script>



    $(".datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });
    $(".datepicker1").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    const paymentFrequencySelect = document.getElementById("payment_frequency");
    const rateFieldSelect = document.getElementById("rate_fields");
    const minimumSalaryFields = document.getElementById("minimum_salary_fields");
    const maximumSalaryFields = document.getElementById("maximum_salary_fields");
    const startingSalaryFields = document.getElementById("starting_salary_fields");
    const exactSalaryFields = document.getElementById("exact_salary_fields");

    paymentFrequencySelect.addEventListener("change", function () {
        // Hide all fields initially
        minimumSalaryFields.style.display = "none";
        maximumSalaryFields.style.display = "none";
        startingSalaryFields.style.display = "none";
        exactSalaryFields.style.display = "none";
        rateFieldSelect.style.display = "none";

        // Show fields based on the selected option
        const selectedOption = this.value;
        if (selectedOption === "range") {
            minimumSalaryFields.style.display = "block";
            maximumSalaryFields.style.display = "block";
            rateFieldSelect.style.display = "block";
        } else if (selectedOption === "starting salary") {
            startingSalaryFields.style.display = "block";
            rateFieldSelect.style.display = "block";
        } else if (selectedOption === "maximum salary") {
            maximumSalaryFields.style.display = "block";
            rateFieldSelect.style.display = "block";
        } else if (selectedOption === "exact salary") {
            exactSalaryFields.style.display = "block";
            rateFieldSelect.style.display = "block";
        }
    });

    $(function () {
        $("#multiSelectSkill").each(function () {
            $(this).select2({
                theme: "bootstrap4",
                width: "style",
                placeholder: $(this).attr("placeholder"),
                allowClear: Boolean($(this).data("allow-clear")),
            });
        });
        $("#multiSelectLocation").each(function () {
            $(this).select2({
                theme: "bootstrap4",
                width: "style",
                placeholder: $(this).attr("placeholder"),
                allowClear: Boolean($(this).data("allow-clear")),
            });
        });
        $("#multiSelectPerk").each(function () {
            $(this).select2({
                theme: "bootstrap4",
                width: "style",
                placeholder: $(this).attr("placeholder"),
                allowClear: Boolean($(this).data("allow-clear")),
            });
        });
        $("#multiSelectEducation").each(function () {
            $(this).select2({
                theme: "bootstrap4",
                width: "style",
                placeholder: $(this).attr("placeholder"),
                allowClear: Boolean($(this).data("allow-clear")),
            });
        });
    });

    $('#end_date').on('blur', function () {
        validateEndDate();
    });

    function validateEndDate() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();

        if (startDate && endDate) {

            var startDateObj = new Date(startDate);
            var endDateObj = new Date(endDate);

            // Compare the dates
            if (endDateObj <= startDateObj) {
                $('#end_date_error').text('Please select a date greater than the start date.');
                $('#end_date').val('');
            } else {
                $('#end_date_error').text('');
            }
        }
    }

    $('#start_date').on('blur', function () {
        validateStartDate();
    });

    function validateStartDate() {
        var startDate = $('#start_date').val();

        if (startDate) {
            // Parse the date string to a Date object
            var startDateObj = new Date(startDate);
            startDateObj.setHours(0, 0, 0, 0);

            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);

            if (startDateObj < currentDate) {
                $('#start_date_error').text('Please select a start date greater than or equal to the current date.');
                $('#start_date').val('');
            } else {
                $('#start_date_error').text('');
            }
        }
    }


    $(document).ready(function () {
        $('#experience_years, #experience_months').on('change', function () {
            var years = parseInt($('#experience_years').val()) || 0;
            var months = parseInt($('#experience_months').val()) || 0;

            if (years < 0 || months < 0) {
                $('#exp_error').text('Years and months of experience must be greater than or equal to 0.');
            } else {
                $('#exp_error').text('');
            }
        });
        $('#minimum_salary, #maximum_salary').on('change', function () {
            var minimumSalary = parseInt($('#minimum_salary').val()) || 0;
            var maximumSalary = parseInt($('#maximum_salary').val()) || 0;
            if (minimumSalary < 0 || maximumSalary < 0) {
                $('#salary_error').text('Minimum and maximum salary must be greater than or equal to 0.');
            } else if (maximumSalary < minimumSalary) {
                $('#salary_error').text('Maximum salary must be greater than the minimum salary.');
            } else {
                $('#salary_error').text('');
            }
        });
    });


</script>
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
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.company_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('company.index') }}",
            'columnDefs': [
            {
                'targets': 0,
                'checkboxes': {
                'selectRow': true
                }
            }
        ],
        'select': {
            'style': 'multi'
        },
        'order': [[1, 'asc']],
            columns: [
                // {"data": "checkbox", orderable:false, searchable:false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'website', name: 'website'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    $(document).ready(function() {
        // Initialize the "Select All" checkbox
        $('#selectAll').click(function() {
            $('input[type="checkbox"]').prop('checked', this.checked);
            $("#btn-submit").toggle();
        });
    });



    function checkSelectRow() {
            $("#btn-submit").toggle();
    }

  function deleteCompany(e) {
    var url = '{{ route("company.destroy", ":id") }}';
        url = url.replace(':id', e);

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
      Swal.fire({
          title             : "Delete",
          text              : "Do you realy want to delete!",
          icon              : "warning",
          showCancelButton  : true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor : "#d33",
          confirmButtonText : "Yes, Delete this item!"
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url    : url,
                  type   : "delete",
                  success: function(data) {
                        if (data.success) {
                        $('.company_datatable').DataTable().ajax.reload();
                        Swal.fire('Deleted!','Your file has been deleted.',
                        'success')
                        }
                  }
              })
          }
      })
  }
</script>
@endpush
@endsection