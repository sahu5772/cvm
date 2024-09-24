@extends('layouts.app')
@section('content')
    <main class="report-wrapper">
        <section class="inner__wrapper">
            <div class="container-fluid">
                <div class="title">Candidates Reports</div>

                <div class="row">
                    <div class="col-3">
                        <div class="general_filter">
                            <div class="first-filter-header">
                                <h3 class="general-filters-cont">Filters
                                    <div class="notification">
                                        <a href="{{ route('report.index') }}">
                                            <img src="{{ asset('/') }}images/icons/undo-arrow.png" width="20"
                                                alt="">
                                        </a>
                                    </div>
                                </h3>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <div class="filter-icons-flex">
                                                <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Project Details
                                                </button>
                                                <img src="{{ asset('images/icons/select-drop.png') }}" />
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
                                                    <label for="">Languages</label>
                                                    <select name="language_id" class="language" multiple>
                                                        @foreach ($languages as $language)
                                                            <option value="{{ $language->id }}">{{ $language->name }}
                                                            </option>
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
                                                <div class="input_grp">
                                                    <label for="">Age</label>
                                                    <div class="input-group">
                                                        <input type="number" name="minAge" class="form-control minAge"
                                                            value="" placeholder="Min Age">
                                                        <input type="number" name="maxAge" class="form-control maxAge"
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
                                                <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                                                    aria-controls="#collapseTwo">
                                                    Educational Details
                                                </button>
                                                <img src="{{ asset('images/icons/select-drop.png') }}" />
                                            </div>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="form_wrapper">
                                                <div class="input_grp">
                                                    <label for="">Education</label>
                                                    <select name="subject_id" class="subject_id" multiple>
                                                        @foreach ($educations as $education)
                                                            <option value="{{ $education->id }}">{{ $education->name }}
                                                            </option>
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
                                                        <input type="number" name="minExp" value=""
                                                            class="form-control minExp" placeholder="Min Experience">
                                                        <input type="number" name="maxExp" value=""
                                                            class="form-control maxExp" placeholder="Max Experience">
                                                    </div>
                                                    <div id="exp_error" style="color: red;"></div>
                                                </div>
                                                <div class="input_grp">
                                                    <label for="">Designation</label>
                                                    <select name="designation_id" class="designation_id" multiple>
                                                        @foreach ($designations as $designation)
                                                            <option value="{{ $designation->id }}">
                                                                {{ $designation->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <label for="">Training/Certificate</label>
                                                    <select name="certificate_id" class="certificate_id" multiple>
                                                        @foreach ($certificates as $certificate)
                                                            <option value="{{ $certificate->id }}">
                                                                {{ $certificate->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <label for="">Membership</label>
                                                    <select name="membership_id" class="membership_id" multiple>
                                                        @foreach ($memberships as $membership)
                                                            <option value="{{ $membership->id }}">{{ $membership->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                Other Details
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="form_wrapper">
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Terrain</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Pavement</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Funding Agency</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Sectors</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Phases</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Keywords</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Training/Certification</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Membership</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Mode of Contract</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
                    <div class="col-9">
                        <div class="reports-table-cont">
                            <div class="table__wrapper">
                                <table class="table report-table display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">No.</th> --}}
                                            <th scope="col">Name</th>
                                            <th scope="col">Nationality</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Language</th>
                                            <th scope="col">Desigation</th>
                                            {{-- <th scope="col">Department</th>
                            <th scope="col">Father Name</th>
                            <th scope="col">Mother Name</th>
                            <th scope="col">Aadhar Card</th>
                            <th scope="col">Pan Card</th>
                            <th scope="col">Total Experience</th> --}}
                                            {{-- <th scope="col" width="18%">Action</th> --}}
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
        </section>
    </main>
    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var table = $('.report-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('report.index') }}",
                        data: function(d) {
                            d.country_id = $('.country_id').val(),
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
                                // d.intExperience = $('.intExperience').val(),
                                d.intExperience = $("input[name='intExperience']:checked").val(),
                                d.search = $('input[type="search"]').val()
                        }
                    },
                    columns: [

                        {
                            data: 'first_name',
                            name: 'candidates.id'
                        },
                        {
                            data: 'nationality',
                            name: 'country.name'
                        },
                        {
                            data: 'phone_number',
                            name: 'phone_number'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'language',
                            name: 'language.name'
                        },

                        {
                            data: 'designation',
                            name: 'designation.name'
                        },
                        // {data: 'department', name: 'department.name'},
                        // {data: 'father_name', name: 'father_name'},
                        // {data: 'mother_name', name: 'mother_name'},
                        // {data: 'aadhar_card', name: 'aadhar_card'},
                        // {data: 'pan_card', name: 'pan_card'},
                        // {data: 'total_experience', name: 'total_experience'},
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     orderable: false,
                        //     searchable: false
                        // },
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
                // $('.maxExp').on('change', function() {
                //     table.draw();
                // });

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
                $('.intExperience').on('change', function() {
                    table.draw();
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
        </script>
    @endpush
@endsection
