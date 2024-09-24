@extends('layouts.app')

@section('content')
    <main class="candidate_wrapper">
        <section class="inner__wrapper">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <div class="title">Candidate List</div>
                    <div class="candidate_buttons">
                        <!-- @can('candidate.view')
        <a href="{{ route('candidate.show', 1) }}" class="btn_style ghost_btn">
                                        View Page
                                    </a>
    @endcan -->
                        @can('candidate.add')
                            <a href="{{ route('candidate.create') }}" class="btn_style">
                                <img src="{{ asset('images/icons/icons8-manage-48.png') }}" alt="" />
                                Add Candidate
                            </a>
                        @endcan
                    </div>
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-3 candidate_filter">
                        <div class="general_filter">
                            <div class="first-filter-header">
                                <h3 class="general-filters-cont">Filters
                                    <div class="notification">
                                        <img src="{{ asset('/images/icons/undo-arrow.png') }}" width="20"
                                            alt="">
                                    </div>
                                </h3>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="filter-search">
                                    <div class="search_wrap">
                                        <img src="{{ asset('images/icons/search.png') }}" alt="">
                                        <input type="text" placeholder="Search here...">
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
                                                <img src="{{ asset('images/icons/select-drop.png') }}" />
                                            </div>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="form_wrapper">
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Nationality</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Languages</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Gender</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Age</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
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
                                                <img src="{{ asset('images/icons/select-drop.png') }}" />
                                            </div>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="form_wrapper">
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Qualification Level</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Course/Program</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Experience</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
                                                    </select>
                                                </div>
                                                <div class="input_grp">
                                                    <select name="" id="">
                                                        <option value="" selected>Designation</option>
                                                        <option value="civil">Civil</option>
                                                        <option value="Metro">Metro</option>
                                                        <option value="Test House">Test House</option>
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
                                                <img src="{{ asset('images/icons/select-drop.png') }}" />
                                            </div>
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
                                </div>
                                <div class="filter-search-input">
                                    <div class="form_wrapper">
                                        <div class="input_grp">
                                            <span>International Experience</span>
                                            <div class="radio-container">
                                                <div class="radio">
                                                    <input id="radio-1" name="radio" type="radio" checked>
                                                    <label for="radio-1" class="radio-label">Yes</label>
                                                </div>

                                                <div class="radio">
                                                    <input id="radio-2" name="radio" type="radio">
                                                    <label for="radio-2" class="radio-label">No</label>
                                                </div>

                                                <div class="radio">
                                                    <input id="radio-3" name="radio" type="radio">
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
                        <div class="canadidate-table-heading">
                            <div class="Candidate-active-dropdown">
                                <span>Show</span>
                                <div class="form_wrapper">
                                    <div class="input_grp">
                                        <select name="" id="">
                                            <option value="" selected>25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="160">160</option>
                                            <option value="200">200</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pagination-candidate">
                                <nav data-pagination>
                                    <a href=# disabled><img src="{{ asset('/images/icons/rightarrow.png') }}"
                                            width="20" class="left-arrow"></a>
                                    <ul>
                                        <li class=current><a href=#1>Page 1 of </a>
                                        <li><a href=#2> 21452</a>
                                    </ul>
                                    <a href=#2><img src="{{ asset('/images/icons/rightarrow.png') }}" width="20"></a>
                                </nav>
                            </div>
                        </div>
                        <div class="candidate-active-table candidateData">
                            @foreach ($candidates as $candidate)
                                <div class="card canadidate-card-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="candidate-cards-person">
                                                <form>
                                                    <div class="form-group">
                                                        <input type="checkbox" id="candidate1">
                                                        <label for="candidate1">{{ $candidate->first_name }}</label>
                                                    </div>
                                                    <div class="form-details">
                                                        <div class="form-datails-icons">
                                                            <div class="candidate-exp">
                                                                <img src="{{ asset('/images/icons/exp.png') }}"
                                                                    width="16" alt="">
                                                                <span>{{ $candidate->total_experience }}</span>
                                                            </div>
                                                            <div class="candidate-exp">
                                                                <img src="{{ asset('/images/icons/location.png') }}"
                                                                    width="16" alt="">
                                                                <span>Pune</span>
                                                            </div>
                                                        </div>
                                                        @php
                                                            if (isset($candidate->workExperience[0])) {
                                                                $currentCompany = $candidate->workExperience->last();
                                                                $current = ucfirst($currentCompany->designation->name) . ' at ' . ucfirst($currentCompany->company_name);
                                                            } else {
                                                                $current = '-';
                                                            }

                                                            if (isset($candidate->educationalDetail[0])) {
                                                                $education = $candidate->educationalDetail->last();
                                                                $education = ucfirst($education->educationLevel->name) . ' in ' . ucfirst($education->subject->name) . ' , ' . ucfirst($education->university->name) . ' , ' . ucfirst($education->from_year);
                                                            } else {
                                                                $education = '-';
                                                            }
                                                        @endphp
                                                        <div class="form-detail-container">
                                                            <div class="form-details-job">
                                                                <h4>Verified with email : </h4>
                                                                <span>{{ $candidate->is_email_verified == '1' ? 'Verified' : 'Candidate not verified' }}</span>
                                                            </div>
                                                            <div class="form-details-job">
                                                                <h4>Verified with mobile : </h4>
                                                                <span>{{ $candidate->is_mobile_verified == '1' ? 'Verified' : 'Candidate not verified' }}</span>
                                                            </div>
                                                            <div class="form-details-job">
                                                                <h4>Current : </h4>
                                                                <span>{{ $current }}</span>
                                                            </div>
                                                            <div class="form-details-job">
                                                                <h4>Education : </h4>
                                                                <span>{{ $education }}</span>
                                                            </div>
                                                            <div class="form-details-job">
                                                                <h4>KeySkills : </h4>
                                                                <span>Figma | HTML 4/5 | CSS | Bootstrap | media query |
                                                                    basic
                                                                    jquery | photoshop | UI
                                                                    Developer | Web
                                                                    Designing </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="candidate-profile-detail">
                                                <div class="candidate-profile">
                                                    <img src="{{ ($candidate->profile_image) ? asset('images/candidate/' . $candidate->profile_image) : asset('images/profile.jpg')}}" alt="">
                                                    <h3>{{ $candidate->designation->name }},
                                                        {{ $candidate->total_experience ? $candidate->total_experience : '0' }}
                                                        Years Experience</h3>
                                                    <p>Html, Css, Bootstrap, Jquery, Figma</p>
                                                </div>

                                                <div class="button_flex">
                                                    @can('candidate.view')
                                                        <a href="{{ route('candidate.show', $candidate->id) }}"
                                                            type="reset" class="btn_style ghost_btn">
                                                            View Profile
                                                        </a>
                                                    @endcan
                                                    <button type="submit" class="btn_style"
                                                        onClick="VerifyPhone({{ $candidate->id }})">Verify Phone</button>
                                                    <button type="submit" class="btn_style"
                                                        onClick="VerifyEmail({{ $candidate->id }})">Verify Email</button>
                                                    <a type="submit" class="btn_style" href="{{ route('schedule', $candidate->id) }}"
                                                        >Schedule Interview</a>
                                                    <button type="submit" class="btn_style" onClick="shareDetail({{ $candidate->id }})"
                                                        >Share Details via Email</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- ./row -->
            </div>
            <!-- ./heading -->

            </div>
            <!-- ./container -->
        </section>
    </main>

    <!-- phone -->
    <div class="modal editModel fade" id="editModalPhone" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="mobile-verify">

            </div>
        </div>
    </div>

    <!-- details via email -->
    <div class="modal editModel fade" id="editModalDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="candidateDetailEmail">

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function VerifyPhone(id) {
                var candidate_id = id;
                $.ajax({
                    url: "{{ route('candidate.phone') }}",
                    type: "post",
                    data: {
                        candidate_id: candidate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#mobile-verify').html(response.data);
                        $('#editModalPhone').modal("show");
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                            response.message +
                            '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                        );
                        setTimeout(function() {
                            $('#res_message').fadeIn().fadeOut();
                        }, 4000);
                    }
                });
            }

            function resendOtp(id) {
                var candidate_id = id;
                $.ajax({
                    url: "{{ route('candidate.resend') }}",
                    type: "post",
                    data: {
                        candidate_id: candidate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        // $('#editModalPhone').modal("show");
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                            response.message +
                            '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                        );
                        setTimeout(function() {
                            $('#res_message').fadeIn().fadeOut();
                        }, 4000);
                    }
                });
            }

            function resendOtpEmail(id) {
                var candidate_id = id;
                $.ajax({
                    url: "{{ route('candidate.resend-email') }}",
                    type: "post",
                    data: {
                        candidate_id: candidate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        // $('#editModalPhone').modal("show");
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                            response.message +
                            '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                        );
                        setTimeout(function() {
                            $('#res_message').fadeIn().fadeOut();
                        }, 4000);
                    }
                });
            }

            function submitOtp(id) {
                var candidate_id = id;
                var val = "";
                $('.mobile-otp').each(function(i) {
                    val += $(this).val();
                });
                if (val.length >= 6) {
                    $.ajax({
                        url: "{{ route('candidate.mobile-verify-otp') }}",
                        type: "POST",
                        data: {
                            candidate_id: candidate_id,
                            otp: val,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if ($.isEmptyObject(response.error) && response.status == true) {
                                $('#editModalPhone').modal("hide");
                                $('#res_message').fadeIn().html(
                                    '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                                    response.message +
                                    '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                                );
                                setTimeout(function() {
                                    $('#res_message').fadeIn().fadeOut();
                                }, 4000);
                            } else {
                                $(".otp-mobile").text('Please enter correct otp');
                            }
                        },
                        error: function(response) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                console.log(field_name);
                                $(document).find('.otp-container').after(
                                    '<span class="text-strong textdanger">' + error + '</span>')
                            })
                        }
                    });
                } else {
                    $(".otp-mobile").text('Please enter correct otp');
                }
            }
            // email verify

            function VerifyEmail(id) {
                var candidate_id = id;
                $.ajax({
                    url: "{{ route('candidate.email') }}",
                    type: "post",
                    data: {
                        candidate_id: candidate_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#mobile-verify').html(response.data);
                        $('#editModalPhone').modal("show");
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                            response.message +
                            '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                        );
                        setTimeout(function() {
                            $('#res_message').fadeIn().fadeOut();
                        }, 4000);
                    }
                });
            }

            function SaveOtp(id) {
                var candidate_id = id;
                var val = "";
                $('.email-otp').each(function(i) {
                    val += $(this).val();
                });
                if (val.length >= 6) {

                    $.ajax({
                        url: "{{ route('candidate.mobile-verify-otp') }}",
                        type: "POST",
                        data: {
                            candidate_id: candidate_id,
                            otp: val,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if ($.isEmptyObject(response.error) && response.status == true) {
                                $('#editModalPhone').modal("hide");
                                $('#res_message').fadeIn().html(
                                    '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                                    response.message +
                                    '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                                );
                                setTimeout(function() {
                                    $('#res_message').fadeIn().fadeOut();
                                }, 4000);
                            } else {
                                $(".otp-mobile").text('Please enter correct otp');
                            }
                        },
                        error: function(xhr) {}
                    });
                } else {
                    $(".otp-email").text('Please enter correct otp');
                }
            }

            function shareDetail(id){
                var url = '{{ route('share-detail-modal', ':id') }}';
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        candidate_id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#candidateDetailEmail').html(response.data);
                        $('#editModalDetail').modal("show");
                    }
                });
            }

            function sendDetail(id){
                var candidate_id = id;
                var val = $('#email').val();
                $.ajax({
                        url: "{{ route('share-detail') }}",
                        type: "POST",
                        data: {
                            candidate_id: candidate_id,
                            email: val,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            location.reload();
                        },
                    });
            }
        </script>
    @endpush
@endsection
