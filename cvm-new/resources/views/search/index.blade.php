@extends('layouts.app')
@section('content')

<?php

if(isset(Session::get('filter')['columns'])){
    $filter =  Session::get('filter')?Session::get('filter')['columns']:[];
}else{
    $filter = [];
}
?>
<main class="searchResume-wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="title">Search Resume</div>
            </div>
            <div class="row">
                <div class="col-3 resume_filter">
                    <div class="general_filter">
                        <div class="first-filter-header">
                            <h3 class="general-filters-cont">Filters
                                <div class="notification">
                                    <a href="{{route('search.index')}}">
                                    <img src="{{asset('/')}}images/icons/undo-arrow.png" width="20" alt="">
                                </a>
                                </div>
                            </h3>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="filter-search">
                                <div class="content">
                                    <div class="tag-box" id="commaSep">
                                        <ul>
                                            <input type="text" name="customtext" id="customtext_" placeholder="Search in CV (COMMA SEPARATED VALUES)" value="">
                                        </ul>
                                    </div>
                                </div>
                                <div class="form_wrapper mt-4">
                                    <div class="input_grp">
                                        <div id="customtext" style="display:none"></div>
                                        <select name="searchType" id="searchType">
                                            <option value="any">Any Words (OR)</option>
                                            <option value="all">all Words (AND)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Personal Details
                                            </button>
                                            <img src="{{asset('/')}}images/icons/select-drop.png" />
                                        </div>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <label for="">Nationality</label>
                                                <select name="country_id" class="country_id" multiple>
                                                    @foreach ($country as $vs)
                                                    <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Experience By Country</label>
                                                <select name="ex_country_id" class="ex_country_id" multiple>
                                                    @foreach ($country as $vs)
                                                    <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Languages</label>
                                                <select name="language_id" class="language" multiple>
                                                    @foreach ($languages as $language)
                                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Gender</label>
                                                <select name="gender" class="gender" multiple>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            {{-- <div class="input_grp">
                                                <label for="">Education</label>
                                                <select name="subject_id" class="subject_id" multiple>
                                                    @foreach ($educations as $education)
                                                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="input_grp">
                                                <label for="">Age</label>
                                                <div class="input-group">
                                                    <input type="text" name="minAge" class="form-control minAge"
                                                        value="" placeholder="Min Age">
                                                    <input type="text" name="maxAge" class="form-control maxAge"
                                                        value="" placeholder="Max Age">
                                                </div>
                                                <div id="age_error" style="color: red;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                Educational Details
                                            </button>
                                            <img src="{{asset('/')}}images/icons/select-drop.png" />
                                        </div>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp toggle-eduction-button">
                                                <label>Latest Created Designation<span class="reqText"></span></label>
                                                <div class="switch_button">
                                                    <label class="switch">
                                                        <input type="checkbox" name="latestDesig" id="latestDesig"
                                                            value="">
                                                        <span class="slider"></span>
                                                        <input type="hidden" name="" id="latestDesigInput" value="">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Education</label>
                                                <select name="subject_id" class="subject_id" multiple>
                                                    @foreach ($educations as $education)
                                                    <option value="{{ $education->id }}">{{ $education->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Qualification Level</label>
                                                <select name="educational_level_id" class="educational_level_id"
                                                    multiple>
                                                    @foreach ($educationalLevels as $educationalLevel)
                                                    <option value="{{ $educationalLevel->id }}">
                                                        {{ $educationalLevel->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Experience</label>
                                                <div class="input-group">
                                                    <input type="text" name="minExp" value=""
                                                        class="form-control minExp" placeholder="Min Experience">
                                                    <input type="text" name="maxExp" value=""
                                                        class="form-control maxExp" placeholder="Max Experience">
                                                </div>
                                                <div id="exp_error" style="color: red;"></div>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Designation</label>
                                                <select name="designation_id" class="designation_id" multiple>
                                                    @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}">{{ $designation->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Training/Certificate</label>
                                                <select name="certificate_id" class="certificate_id" multiple>
                                                    @foreach ($certificates as $certificate)
                                                    <option value="{{ $certificate->id }}">{{ $certificate->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Other Details
                                            </button>
                                            <img src="{{asset('/')}}images/icons/select-drop.png" />
                                        </div>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <label for="">Membership</label>
                                                <select name="membership_id" class="membership_id" multiple>
                                                    @foreach ($memberships as $membership)
                                                    <option value="{{ $membership->id }}">{{ $membership->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Sector</label>
                                                <select name="sector_id" class="sector_id" multiple>
                                                    @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Phases</label>
                                                <select name="phase_id" class="phase_id" multiple>
                                                    @foreach ($phases as $phase)
                                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Terrain</label>
                                                <select name="terrain_id" class="terrain_id" multiple>
                                                    @foreach ($terrains as $terrain)
                                                    <option value="{{ $terrain->id }}">{{ $terrain->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Funding Agency</label>
                                                <select name="funding_agency_id" class="funding_agency_id" multiple>
                                                    @foreach ($fundingAgency as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Mode Of Contract</label>
                                                <select name="contract_mode_id" class="contract_mode_id" multiple>
                                                    @foreach ($contracts as $contract)
                                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-search-input">
                                <div class="form_wrapper">
                                    <div class="input_grp">
                                        <span>International Experience</span>
                                        <div class="radio-container">
                                            <div class="radio">
                                                <input id="radio-1" name="intExperience" class="intExperience"
                                                    type="radio" value="yes">
                                                <label for="radio-1" class="radio-label">Yes</label>
                                            </div>
                                            <div class="radio">
                                                <input id="radio-2" name="intExperience" class="intExperience"
                                                    type="radio" value="no">
                                                <label for="radio-2" class="radio-label">No</label>
                                            </div>
                                            <div class="radio">
                                                <input id="radio-3" name="intExperience" class="intExperience"
                                                    type="radio" value="both">
                                                <label for="radio-3" class="radio-label">Both</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9 mt-5">
                    <div class="search-menu-drop">
                        <div class="dropdown filter-table-conatiner">
                            <div class="notification dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('/')}}images/icons/listss.png" alt="" width="15" />
                            </div>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="email-toggle-options">
                                    <span>Fliter Settings</span>
                                    <form>
                                        <div class="form-group">
                                            <input type="checkbox" id="css" value="first_name" disabled='disabled' checked>
                                            <label for="css">Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="javascript"  value="nationality" disabled='disabled' checked>
                                            <label for="javascript">Nationality</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="form" value="phone_number" disabled='disabled' checked>

                                            <label for="form">Phone Number</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="expenses" value="3" @if (in_array('3',$filter))
                                                checked
                                            @endif>
                                            <label for="expenses">Gender</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="project" value="4" @if (in_array('4',$filter))
                                            checked
                                        @endif>
                                            <label for="project">Sector</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="phase" value="5" @if (in_array('5',$filter))
                                            checked
                                        @endif>
                                            <label for="phase">Phase</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="terrain" value="6" @if (in_array('6',$filter))
                                            checked
                                        @endif>
                                            <label for="terrain">Terrain</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="fundingAgency" value="7" @if (in_array('7',$filter))
                                            checked
                                        @endif>
                                            <label for="fundingAgency">funding Agency</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="tasks" value="8" @if (in_array('8',$filter))
                                            checked
                                        @endif>
                                            <label for="tasks">Language</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="request" value="9" @if (in_array('9',$filter))
                                            checked
                                        @endif>
                                            <label for="request">Desigation</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="leave" value="11" @if (in_array('11',$filter))
                                            checked
                                        @endif>
                                            <label for="leave">Father Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="designation" value="12" @if (in_array('12',$filter))
                                            checked
                                        @endif>
                                            <label for="designation">Mother Name</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="aadhar_card" value="13" @if (in_array('13',$filter))
                                            checked
                                        @endif>
                                            <label for="aadhar_card">Aadhar Card</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="pan_card" value="14" @if (in_array('14',$filter))
                                            checked
                                        @endif>
                                            <label for="pan_card">Pan Card</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" id="countryExperience" value="15" @if (in_array('15',$filter))
                                                checked
                                            @endif>
                                            <label for="countryExperience">Country Experience</label>
                                        </div>
                                        <button type="button" class="btn_style filterBtn">
                                            {{-- <img src="http://127.0.0.1:8000/images/icons/icons8-manage-48.png" alt=""> --}}
                                            filter
                                            </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="resume-table-cont">
                        <div class="table__wrapper">
                            <table class="table report-table display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Nationality</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Sector</th>
                                        <th scope="col">Phase</th>
                                        <th scope="col">Terrain</th>
                                        <th scope="col">Funding Agency</th>
                                        <th scope="col">Language</th>
                                        <th scope="col">Desigation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Father Name</th>
                                        <th scope="col">Mother Name</th>
                                        <th scope="col">Aadhar Card</th>
                                        <th scope="col">Pan Card</th>
                                        <th scope="col">Country Experience</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- ./table__wrapper -->
                    </div>
                </div>
            </div>
            <!-- ./row -->
        </div>
        <!-- ./container -->
    </section>
</main>

@push('scripts')


<script type="text/javascript">

$(function() {
    var table = $('.report-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('search.index') }}",
            data: function(d) {
                d.country_id = $('.country_id').val(),
                    d.ex_country_id = $('.ex_country_id').val(),
                    d.gender = $('.gender').val(),
                    d.language = $('.language').val(),
                    d.subject_id = $('.subject_id').val(),
                    d.minAge = $('.minAge').val(),
                    d.maxAge = $('.maxAge').val(),
                    d.minExp = $('.minExp').val(),
                    d.maxExp = $('.maxExp').val(),
                    d.designation_id = $('.designation_id').val(),
                    d.educational_level_id = $('.educational_level_id').val(),
                    d.certificate_id = $('.certificate_id').val(),
                    d.membership_id = $('.membership_id').val(),
                    d.funding_agency_id = $('.funding_agency_id').val(),
                    d.phase_id = $('.phase_id').val(),
                    d.sector_id = $('.sector_id').val(),
                    d.contract_mode_id = $('.contract_mode_id').val(),
                    d.terrain_id = $('.terrain_id').val(),
                    d.latestDesigInput = $('#latestDesigInput').val(),
                    d.searchType = $('#searchType').val(),
                    d.customtext = $('#customtext').html();
                    // d.customtext = $('#customtext_').val();
                    d.intExperience = $("input[name='intExperience']:checked").val(),
                    d.search = $('input[type="search"]').val()
            }
        },


         columns: [
             {
                 data: 'first_name',
                 name: 'first_name',
             },
             {
                 data: 'nationality',
                 name: 'country.name',
             },
             {
                 data: 'phone_number',
                 name: 'phone_number',
             },
             {
                 data: 'gender',
                 name: 'gender',
                 visible: false,
             },
             {
                 data: 'project',
                 name: 'sectors.name',
                 visible: false,
             },
             {
                 data: 'phase',
                 name: 'phase.id',
                 visible: false,
             },
             {
                 data: 'terrain',
                 name: 'terrain.id',
                 visible: false,
             },
             {
                 data: 'fundingAgency',
                 name: 'fundingAgency.id',
                 visible: false
             },
             {
                 data: 'language',
                 name: 'language.id',
                 visible: false
             },

             {
                 data: 'designation',
                 name: 'designation.id',
                 visible: false
             },
             {
                 data: 'department',
                 name: 'department.id',
                 visible: false
             },
             {
                 data: 'father_name',
                 name: 'father_name',
                 visible: false
             },
             {
                 data: 'mother_name',
                 name: 'mother_name',
                 visible: false
             },
             {
                 data: 'aadhar_card',
                 name: 'aadhar_card',
                 visible: false
             },
             {
                 data: 'pan_card',
                 name: 'pan_card',
                 visible: false
             },
             {
                 data: 'countryExperience',
                 name: 'countryExperience',
                 visible: false,
             },
             {
                 data: 'total_experience',
                 name: 'total_experience',
                 visible: false
             },
             
            //   {
            //       data: 'action',
            //       name: 'action',
            //       orderable: false,
            //       searchable: false
            //   },
         ]
    });
    $('.country_id').on('change', function() {
        table.draw();
    });

    $('.minAge').on('change', function() {
        table.draw();
    });
    $('.maxAge').on('change', function() {
        var minAge = parseInt($('.minAge').val()) || 0;
        var maxAge = parseInt($('.maxAge').val()) || 0;

        if (minAge < 0 || maxAge < 0) {
            $('#age_error').text('Age must be greater than or equal to 0.');
        } else if (maxAge < minAge) {
            $('#age_error').text("Max age cannot be less than min age.");
        } else {
            $('#age_error').text('');
            table.draw();
        }
    });
    $('.language').on('change', function() {
        table.draw();
    });
    $('.designation').on('change', function() {
        table.draw();
    });
    $('.gender').on('change', function() {
        table.draw();
    });
    $('.educational_level_id').on('change', function() {
        table.draw();
    });
    $('.designation_id').on('change', function() {
        table.draw();
    });
    $('.certificate_id').on('change', function() {
        table.draw();
    });
    $('.membership_id').on('change', function() {
        table.draw();
    });
    $('.minExp').on('change', function() {
        table.draw();
    });
    $('.intExperience').on('change', function() {
        table.draw();
    });
    $('.maxExp').on('change', function() {
        var minExp = parseInt($('.minExp').val()) || 0;
        var maxExp = parseInt($('.maxExp').val()) || 0;
        if (minExp < 0 || maxExp < 0) {
            $('#exp_error').text('Experience must be greater than or equal to 0.');
        } else if (maxExp < minExp) {
            $('#exp_error').text("Max experience cannot be less than min age.");
        } else {
            $('#exp_error').text('');
            table.draw();
        }
    });
    $('.subject_id').on('change', function() {
        table.draw();
    });
    $('.sector_id').on('change', function() {
        table.draw();
    });
    $('.funding_agency_id').on('change', function() {
        table.draw();
    });
    $('.phase_id').on('change', function() {
        table.draw();
    });
    $('.terrain_id').on('change', function() {
        table.draw();
    });
    $('.contract_mode_id').on('change', function() {
        table.draw();
    });
    $('#latestDesig').on('change', function() {
        table.draw();
    });
    $('#searchType').on('change', function() {
        table.draw();
    });
    $('#customtext').on('keypress', function() {
        table.draw();
    });

    $('.ex_country_id').on('change', function() {
        table.draw();
    });

    var sessionData = @json(Session::get('filter'));
    console.log(sessionData);
    if (sessionData) {
    $.each(sessionData.columns, function( index, value ) {
    table.column(value).visible(true);
    });
    }


    $('.filterBtn').on('click', function () {
      var columns = [];
    $(':checkbox:checked').each(function(i) {
        columns[i] = $(this).val();
    });

    $.ajax({
        method: 'GET',
        url: "{{ route('search.filter') }}",
        data: {
            columns,
        },
        success: function (response) {
            if (response.data) {
            // $.each(response.data.columns, function( index, value ) {
            // table.column(value).visible(true);
            // });
            location.reload();

            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});


});

$(".country_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".ex_country_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".language").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".gender").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".subject_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".educational_level_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".designation_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".certificate_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".membership_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".funding_agency_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".contract_mode_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".terrain_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".sector_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".phase_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".contract_mode_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});

$("#latestDesig").change(function() {
    var ischecked = $(this).is(':checked');
    if (!ischecked) {
        $('#latestDesigInput').val('');
    } else {
        $('#latestDesigInput').val(1);
    }
});
$(document).ready(function() {
    $('div.tag-box > ul > input').keydown(function(e) {
        if (e.which == 188) { // check comma
            e.preventDefault(); // no comma
            var value = $(this).val();
            var matches = 0;
            $('#customtext').append(',' + value);
            $('div.tag-box > ul > li').each(function() { // avoid duplicates
                if ($(this).html() == value) {
                    matches++;
                }

            });

            if (matches == 0 && value.replace(/\s/g, '').length > 0) {
                createTag($(this).val());
            }
            $(this).val('');

        } else if (e.which == 8 && $(this).val().length == 0) { // check delete pressed and length = 0

            removeTag($('div.tag-box > ul > li:last-of-type'));
        }

    });

    $(document).on('click', 'div.tag-box > ul > li', function() {
        removeTag($(this));
    });
});

var strArr = [];
function createTag(string) {
    $('div.tag-box > ul input').before('<li>' + string.replaceAll(' ', '') + '</li>');
}

function getTags() {
    var result = '';
    $('div.tag-box > ul > li').each(function() {
        result = result + '' + $(this).html() + ', ';
    });
    var result = result.substring(0, result.length - 2)
    return result;
}

function removeTag(jquerys) {

    jquerys.remove();

        $("#customtext").empty();
        var strArr = [];
        $("#commaSep ul > li").each(function(index, elem) {
            strArr.push($(this).text());
        });
        $("#customtext").text(strArr.join(","));
    //fire commaSeparated
}

</script>

@endpush
@endsection