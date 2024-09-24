<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-project" id="drawerMenu-form">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawerProject">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                Add Project Details
            </div>
            <div class="form_wrapper">
                <form id="submitCandidateProject" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Name of Project<span class="reqText">*</span></label>
                                <input type="text" name="name" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project Duration(From)<span class="reqText">*</span></label>
                                <input type="date" name="from" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project Duration(To)<span class="reqText">*</span></label>
                                <input type="date" name="to" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Designation<span class="reqText">*</span></label>
                                <select name="designation_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{( $designation->id )}}">{{( ucfirst($designation->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Industry<span class="reqText">*</span></label>
                                <select name="industry_id" id="industryId">
                                    <option value="" selected>Select option</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{( $industry->id )}}">{{( ucfirst($industry->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Sector<span class="reqText">*</span></label>
                                <select name="sector_id" id="sector-data">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Phase<span class="reqText">*</span></label>
                                <select name="phase_id" id="phase-data">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Name of Employer</label>
                                <input type="text" name="employer_name" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Nature of Employer</label>
                                <select name="employer_type_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($employerType as $employerNature)
                                        <option value="{{( $employerNature->id )}}">{{( ucfirst($employerNature->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project Experience<span class="reqText">*</span></label>
                                <select name="project_type" id="">
                                    <option value="" selected>Select option</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project Country<span class="reqText">*</span></label>
                                <select name="country_id" class="country">
                                    <option value="" selected>Select option</option>
                                    @foreach ($countries as $country)
                                        <option value="{{( $country->id )}}">{{( ucfirst($country->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project State<span class="reqText">*</span></label>
                                <select name="state_id" class="state">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project City<span class="reqText">*</span></label>
                                <select name="city_id" class="city"></select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Total Project Length<span class="reqText">*</span></label>
                                <input type="number" name="project_length" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Project Cost</label>
                                <input type="number" name="project_cost" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Funding Agency <span class="reqText">*</span></label>
                                <select name="funding_agency_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($fundingAgencies as $fundingAgency)
                                        <option value="{{( $fundingAgency->id )}}">{{( ucfirst($fundingAgency->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Mode of Contract<span class="reqText">*</span></label>
                                <select name="contract_mode_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($contractModes as $contractMode)
                                        <option value="{{( $contractMode->id )}}">{{( ucfirst($contractMode->name) )}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <label for="">Terrain<span class="reqText">*</span></label>
                                <select name="terrain_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($terrains as $terrain)
                                        <option value="{{ $terrain->id}}">{{( ucfirst($terrain->name))}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ./row -->

                    <div class="button_flex">
                        <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                            Reset
                        </button>
                        <button type="submit" class="btn_style">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- container -->
    </main>
</div>


@push('scripts')

<script>
    // =========== Drawer form project
    (function() {
        let sidebar = document.getElementById("drawerMenu-form");
        let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
        let sidebarBtnClose = document.getElementById("closeDrawerProject");
        let sidebarBtnOpen = document.getElementsByClassName(" drawerMenu-form");

        let openSidebar = function() {
            sidebarOverlay.style.left = "0";
            sidebar.style.right = "0";
        };

        let closeSidebar = function(e) {
            e.cancelBubble = true;
            sidebarOverlay.style.left = "-100%";
            sidebar.style.right = "-100%";
        };

        sidebarOverlay.addEventListener("click", closeSidebar);
        sidebarBtnClose.addEventListener("click", closeSidebar);

        for (let i = 0; i < sidebarBtnOpen.length; i++) {
            sidebarBtnOpen[i].addEventListener("click", openSidebar);
        }
    })();

    if ($("#submitCandidateProject").length > 0) {
        $("#submitCandidateProject ").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
                from: {
                    required: true,
                },
                to: {
                    required: true,
                },
                designation_id: {
                    required: true,
                },
                industry_id: {
                    required: true,
                },
                sector_id: {
                    required: true,
                },
                phase_id: {
                    required: true,
                },
                project_experience: {
                    required: true,
                },
                country_id: {
                    required: true,
                },
                state_id: {
                    required: true,
                },
                city_id: {
                    required: true,
                },
                project_length: {
                    required: true,
                },
                funding_agency_id: {
                    required: true,
                },
                contract_mode_id: {
                    required: true,
                },
                terrain_id: {
                    required: true,
                },
            },
            submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = '{{ route("candidate-project.store") }}';
            $.ajax({
                url: url ,
                type: "POST",
                data: $('#submitCandidateProject').serialize(),
                success: function( response ) {
                    $('#submitCandidateProject').trigger("reset");
                    drawerCloseSidebar();
                    $('.candidateProject').DataTable().ajax.reload();
                    $('#res_message').fadeIn().html(
                        '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">' +
                        response.message +
                        '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>'
                        );
                    setTimeout(function() {
                        $('#res_message').fadeIn().fadeOut();
                    }, 4000);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            }
        })
    }

    function drawerCloseSidebar(){

        $('.sidebar-overlay-form').css('left','-100%')
        $('.dropSide-candidate-project').css('right','-100%')
    };

    $('#industryId').on('change', function () {

        var id = this.value;

        $.ajax({
            url: "{{url('sector-list')}}",
            type: "POST",
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#sector-data').html('<option value=""> Select Option </option>');
                $.each(result.sector, function (key, value) {
                    $("#sector-data").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    $('#sector-data').on('change', function () {

        var id = this.value;

        $.ajax({
            url: "{{url('phase-list')}}",
            type: "POST",
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#phase-data').html('<option value=""> Select Option </option>');
                $.each(result.phase, function (key, value) {
                    $("#phase-data").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

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
</script>
@endpush