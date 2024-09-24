@extends('layouts.app')
@section('content')
<main class="addEmployee_wrapper">
    <div class="container">
        <div class="title">Edit Job</div>
        <div class="form_wrapper">
            <form action="{{ route('job.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job title <span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="text" name="title" value="{{ $job->title }}" id="add_job_title" placeholder="Enter your Job title" autocomplete="off" />
                            </div>
                            @if ($errors->has('title'))
                                <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job Category<span class="reqText">*</span></label>
                            <select id="categorySelect" class="form-control" name="job_category_id" value="{{ old('job_category_id') }}">
                                <option selected="selected">Choose Category...</option>
                                @foreach ($jobCategory as $jobCat)
                                    <option value="{{ $jobCat->id }}" {{ $job->job_category_id == $jobCat->id ? 'selected' : '' }}>{{ $jobCat->name }}</option>
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
                            <select id="subCategorySelect" class="form-control" name="job_sub_category_id" value="{{ old('job_sub_category_id') }}">
                            </select>
                            @if ($errors->has('job_sub_category_id'))
                                <span class="text-danger text-left">{{ $errors->first('job_sub_category_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Department<span class="reqText">*</span></label>
                            <select name="department_id" class="department" id="department">
                                <option value="" selected>Please select department</option>
                                @foreach ($department as $dPart)
                                    <option value="{{ $dPart->id }}" {{ $job->department_id == $dPart->id ? 'selected' : '' }}>{{ $dPart->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department_id'))
                            <span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
                        @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp multiSelect">
                            <label for="multiSelectSkill">Skill<span class="reqText">*</span></label>
                            <select multiple class="multiSelect_field" name="skill_id[]" data-placeholder="Choose skills" data-allow-clear="1" id="multiSelectSkill">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ $skillExits->contains('skill_id', $skill->id) ? 'selected' : '' }}>
                                        {{ $skill->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('skill_id'))
                            <span class="text-danger text-left">{{ $errors->first('skill_id') }}</span>
                        @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_grp multiSelect">
                            <label for="location">Company Location<span class="reqText">*</span></label>
                            <select multiple placeholder="Choose location" data-allow-clear="1" name="company_location_id[]" id="multiSelectLocation">
                                @foreach ($businessUnits as $businessUnit)
                                    @php
                                        $isSelected = $exitLocation->contains('business_unit_id', $businessUnit->id);
                                    @endphp
                                    <option value="{{ $businessUnit->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $businessUnit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('company_location_id'))
                            <span class="text-danger text-left">{{ $errors->first('company_location_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Start Date<span class="reqText">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ $job->start_date }}" placeholder="type here..." />
                            @if ($errors->has('start_date'))
                                <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                            @endif
                            <div id="start_date_error" style="color: red;"></div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">End Date<span class="reqText">*</span></label>
                            <input type="date" name="end_date" id="end_date" value="{{ $job->end_date }}" placeholder="type here..." />
                            @if ($errors->has('end_date'))
                                <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                            @endif
                            <div id="end_date_error" style="color: red;"></div>
                        </div>

                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Openings<span class="reqText"></span></label>
                            <div class="add_input_option">
                                <input type="number" name="openings" value="{{ $job->openings }}" id="add_openings" placeholder="Enter your opemimgs" autocomplete="off" />
                            @if ($errors->has('openings'))
                                <span class="text-danger text-left">{{ $errors->first('openings') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Job Type<span class="reqText">*</span></label>
                            <select name="job_type_id" class="job_type" id="job_type">
                                <option value="" selected>Please select Job Type</option>
                                @foreach ($jobTypes as $jobType)
                                    <option value="{{ $jobType->id }}" {{ $job->job_type_id == $jobType->id ? 'selected' : '' }}>{{ $jobType->name }}</option>
                                @endforeach
                            </select>
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
                                    <input type="number" name="experience_years" value="{{ $years }}" id="experience_years"
                                        placeholder="Years" autocomplete="off" />
                                </div>

                                <div class="add_input_option">
                                    <input type="number" name="experience_months" value="{{ $months }}" id="experience_months"
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
                            <select name="payment_frequency" class="payment_frequency" id="payment_frequency">
                                <option value="" selected>Please select Payment Frequency</option>
                                <option value="range" {{ $job->payment_frequency == 'range' ? 'selected' : '' }}>Range</option>
                                <option value="starting salary" {{ $job->payment_frequency == 'starting salary' ? 'selected' : '' }}>Starting Salary</option>
                                <option value="maximum salary" {{ $job->payment_frequency == 'maximum salary' ? 'selected' : '' }}>Maximum Salary</option>
                                <option value="exact salary" {{ $job->payment_frequency == 'exact salary' ? 'selected' : '' }}>Exact Salary</option>
                            </select>
                            @if ($errors->has('payment_frequency'))
                                <span class="text-danger text-left">{{ $errors->first('payment_frequency') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4" id="minimum_salary_fields">
                        <div class="input_grp">
                            <label for="">Minimum Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="minimum_salary" value="{{ old('minimum_salary', $job->minimum_salary) }}" id="minimum_salary" placeholder="Enter Your Minimum Salary" autocomplete="off" />
                            </div>
                            @if ($errors->has('minimum_salary'))
                                <span class="text-danger text-left">{{ $errors->first('minimum_salary') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4" id="maximum_salary_fields">
                        <div class="input_grp">
                            <label for="">Maximum Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="maximum_salary" value="{{ old('maximum_salary', $job->maximum_salary) }}" id="maximum_salary" placeholder="Enter Your Maximum Salary" autocomplete="off" />
                            </div>
                            @if ($errors->has('maximum_salary'))
                                <span class="text-danger text-left">{{ $errors->first('maximum_salary') }}</span>
                            @endif
                            <div id="salary_error" style="color: red;"></div>
                        </div>
                    </div>


                    <div class="col-sm-4" id="starting_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Starting Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="starting_salary" value="{{ $job->starting_salary }}" id="starting_salary" placeholder="Enter Your Starting Salary" autocomplete="off" />
                            </div>
                            @if ($errors->has('starting_salary'))
                                <span class="text-danger text-left">{{ $errors->first('starting_salary') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4" id="exact_salary_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="">Exact Salary<span class="reqText">*</span></label>
                            <div class="add_input_option">
                                <input type="number" name="exact_salary" value="{{ $job->exact_salary }}" id="exact_salary" placeholder="Enter Your Exact Salary" autocomplete="off" />
                            </div>
                            @if ($errors->has('exact_salary'))
                                <span class="text-danger text-left">{{ $errors->first('exact_salary') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-4" id="rate_fields" style="display: none;">
                        <div class="input_grp">
                            <label for="rate">Rate<span class="reqText">*</span></label>
                            <select name="rate" class="rate" id="rate">
                                <option value="" selected>Please select Rate</option>
                                <option value="hour" {{ $job->rate == 'hour' ? 'selected' : '' }}>Hourly</option>
                                <option value="day" {{ $job->rate == 'day' ? 'selected' : '' }}>Daily</option>
                                <option value="week" {{ $job->rate == 'week' ? 'selected' : '' }}>Weekly</option>
                                <option value="month" {{ $job->rate == 'month' ? 'selected' : '' }}>Monthly</option>
                                <option value="year" {{ $job->rate == 'year' ? 'selected' : '' }}>Yearly</option>
                            </select>
                            @if ($errors->has('rate'))
                                <span class="text-danger text-left">{{ $errors->first('rate') }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="col-sm-4">
                        <div class="input_grp">
                            <label for="">Currency <span class="reqText">*</span></label>
                            <select name="currency_id" class="currency_id" id="currency_id">
                                <option value="" selected>Please select Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ $job->currency_id == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('currency_id'))
                                <span class="text-danger text-left">{{ $errors->first('currency_id') }}</span>
                            @endif
                        </div>
                    </div>

                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label>Education<span class="reqText">*</span></label>
                                <select multiple placeholder="Choose Education" data-allow-clear="1" name="educational_level_id[]" id="multiSelectEducation">
                                    @foreach ($educations as $educationOption)
                                        <option value="{{ $educationOption->id }}" {{ $education->contains('educational_level_id', $educationOption->id) ? 'selected' : '' }}>
                                            {{ $educationOption->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('educational_level_id'))
                                    <span class="text-danger text-left">{{ $errors->first('educational_level_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="input_grp">
                                <label for="">Description <span class="reqText"></span></label>
                                <textarea rows="3" cols="50" type="text" name="description" id="add_description"
                                    placeholder="Enter your job description" class="form-control">{{ $job->description }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                            @endif
                            </div>
                        </div>

                        <!-- Benefits And Perks -->
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Benefits And Perks<span class="reqText">*</span></label>
                               <select multiple placeholder="Choose Education" data-allow-clear="1" name="company_perk_id[]" id="multiSelectPerk">
                                    @foreach ($companyPerk as $perk)
                                        <option value="{{ $perk->id }}" {{ in_array($perk->id, $companyPerks->pluck('company_perk_id')->toArray()) ? 'selected' : '' }}>
                                            {{ $perk->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company_perk_id'))
                            <span class="text-danger text-left">{{ $errors->first('company_perk_id') }}</span>
                        @endif
                            </div>
                        </div>
                        <!-- Industry -->
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="industry">Industry<span class="reqText">*</span></label>
                                <select name="industry_id" class="industry" id="industry">
                                    <option value="" selected>Please select Industry</option>
                                    <option value="1" {{ $job->industry_id == 1 ? 'selected' : '' }}>First</option>
                                    <option value="2" {{ $job->industry_id == 2 ? 'selected' : '' }}>Second</option>
                                </select>
                        @if ($errors->has('industry_id'))
                            <span class="text-danger text-left">{{ $errors->first('industry_id') }}</span>
                        @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_grp">
                                <label>Is it a Remote Job?<span class="reqText"></span></label>
                                <div class="switch_button">
                                    <label class="switch">
                                        <input type="checkbox" name="is_remote_job" class="toggle-checkbox" value="{{ $job->is_remote_job == 'Yes' ? 'Yes' : 'No' }}" {{ $job->is_remote_job == 'Yes' ? 'checked' : '' }} />
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
                                        <input type="checkbox" class="toggle-checkbox" name="disclose_salary" value="{{ $job->disclose_salary == 'Yes' ? 'Yes' : 'No' }}" {{ $job->disclose_salary == 'Yes' ? 'checked' : '' }} />
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
                                        <input type="checkbox" class="toggle-checkbox" name="photo" value="{{ $job->photo == 'Required' ? 'Required' : 'Not Required' }}" {{ $job->photo == 'Required' ? 'checked' : '' }} />
                                        <span class="slider"></span>
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
                                        <input type="checkbox" class="toggle-checkbox" name="resume" value="{{ $job->resume == 'Required' ? 'Required' : 'Not Required' }}" {{ $job->resume == 'Required' ? 'checked' : '' }} />
                                        <span class="slider"></span>
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
                                        <input type="checkbox" class="toggle-checkbox" name="dob" value="{{ $job->dob == 'Required' ? 'Required' : 'Not Required' }}" {{ $job->dob == 'Required' ? 'checked' : '' }} />

                                        <span class="slider"></span>
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
                                        <input type="checkbox" class="toggle-checkbox" name="gender" value="{{ $job->gender == 'Required' ? 'Required' : 'Not Required' }}" {{ $job->gender == 'Required' ? 'checked' : '' }} />
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_grp">
                                <label>Show Recruiter<span class="reqText"></span></label>
                                <div class="switch_button">
                                    <label class="switch">
                                        <input type="checkbox" name="show_recruiter" class="toggle-checkbox" value="{{ $job->show_recruiter == 'Yes' ? 'Yes' : 'No' }}" {{ $job->show_recruiter == 'Yes' ? 'checked' : '' }} />
                                        <span class="slider"></span>
                                        @if ($errors->has('show_recruiter'))
                                            <span class="text-danger text-left">{{ $errors->first('show_recruiter') }}</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="selectedSubCategoryId" name="selected_sub_category_id" value="{{ $job->job_sub_category_id ?? '' }}">
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
@push('scripts')
<script>
$(document).ready(function() {
    var selectedSubCategoryId = $('#selectedSubCategoryId').val();

    $('#categorySelect').on('change', function() {
        var categoryId = $(this).val();
        if (categoryId !== '') {
            $.ajax({
                url: '{{ route('getSubcategories', ['id' => 'categoryId']) }}'.replace('categoryId', categoryId),
                type: 'GET',
                success: function(response) {
                    $('#subCategorySelect').html('<option>Choose Sub Category...</option>');
                    $.each(response, function(key, value) {
                        var selected = (value.id == selectedSubCategoryId) ? 'selected' : '';
                        $('#subCategorySelect').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#subCategorySelect').html('<option selected="selected">Choose Sub Category...</option>');
        }
    });

    @if(isset($job))
        $('#categorySelect').val('{{ $job->job_category_id }}');
        $('#categorySelect').trigger('change');
    @endif
});

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

        let previousOption = paymentFrequencySelect.value;
        let previousValues = {};

        function showFields(selectedOption) {

            if (selectedOption !== previousOption) {
                for (const key in previousValues) {
                    if (previousValues.hasOwnProperty(key)) {
                        document.getElementById(key).value = '';
                    }
                }
                previousValues = {};
            }

            minimumSalaryFields.style.display = "none";
            maximumSalaryFields.style.display = "none";
            startingSalaryFields.style.display = "none";
            exactSalaryFields.style.display = "none";
            rateFieldSelect.style.display = "none";

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


            previousOption = selectedOption;
            previousValues = {
                "minimum_salary": document.getElementById("minimum_salary").value,
                "maximum_salary": document.getElementById("maximum_salary").value,
                "starting_salary": document.getElementById("starting_salary").value,
                "exact_salary": document.getElementById("exact_salary").value,
                "rate": document.getElementById("rate").value,
            };
        }

        paymentFrequencySelect.addEventListener("change", function () {
            showFields(this.value);
        });

    showFields(paymentFrequencySelect.value);


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


document.addEventListener("DOMContentLoaded", function() {
  const toggleCheckboxes = document.querySelectorAll(".toggle-checkbox");

  toggleCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener("click", function() {
      if (this.value === "Yes") {
        this.value = "No";
      } else if (this.value === "No") {
        this.value = "Yes";
      } else if (this.value === "Required") {
        this.value = "Not Required";
      } else {
        this.value = "Required";
      }
    });
  });
});

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

@endpush
@endsection