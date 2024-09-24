<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-form" id="drawerMenu-professional">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawerProfessional">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                {{ __('messages.add')}} {{ __('messages.candidate.professional_details')}}
            </div>
            <div class="form_wrapper">
                <form id="submitProfessionalForm" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Company<span class="reqText">*</span></label>
                                <input type="text" name="company_name" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">From Date<span class="reqText">*</span></label>
                                <input type="date" name="from_date" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6" id="endDate">
                            <div class="input_grp">
                                <label for="">To Date<span class="reqText">*</span></label>
                                <input type="date" name="to_date" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <label class="switch" for="">Curently working with the organization<span class="reqText">*</span></label>
                            <input type="checkbox" id="currentlyWorking" value="false" name="currently_working">
                            <div class="slider round"></div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Designation<span class="reqText">*</span></label>
                                <select name="designation_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ ucfirst($designation->name)}}</option>
                                    @endforeach
                                    <option value="Metro">Metro</option>
                                    <option value="Test House">Test House</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">H.O.Country<span class="reqText">*</span></label>
                                <select name="country_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($countries as $country )
                                        <option value="{{ $country->id }}">{{ $country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Job Type<span class="reqText">*</span></label>
                                <select name="job_type_id" id="">
                                    <option value="" selected>Select option</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Responsibilities<span class="reqText">*</span></label>
                                <input type="text" name="responsibilities" placeholder="type here..." />
                            </div>
                        </div>
                    </div>
                    <!-- ./row -->

                    <div class="button_flex">
                        <button type="reset" class="btn_style ghost_btn" data-dismiss="modal">
                            Reset
                        </button>
                        <button type="submit" id="submitProfessionalButton" class="btn_style">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- container -->
    </main>
</div>


@push('scripts')

<script>

    $("#currentlyWorking").on('change', function() {
        if ($(this).is(':checked')) {
            $("#endDate").hide();
        }
        else {
            $("#endDate").show();
        }
    });

    if ($("#submitProfessionalForm").length > 0) {
        $("#submitProfessionalForm ").validate({
        rules: {
            company_name: {
            required: true,
            maxlength: 50
        },
        from_date: {
            required: true,
        },
        designation_id: {
            required: true,
        },
        country_id: {
            required: true,
        },
        job_type_id: {
            required: true,
        },
        responsibilities: {
            required: true,
        },
        },
        submitHandler: function(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = '{{ route("candidate-work-experience.store") }}';
        $.ajax({
            url: url ,
            type: "POST",
            data: $('#submitProfessionalForm').serialize(),
            success: function( response ) {
                $('#submitProfessionalForm').trigger("reset");
                drawerCloseSidebar();
                $('.candidateExperience').DataTable().ajax.reload();
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

   // =========== Drawer form professional
    (function () {
        let sidebar = document.getElementById("drawerMenu-professional");
        let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
        let sidebarBtnClose = document.getElementById("closeDrawerProfessional");
        let sidebarBtnOpen = document.getElementsByClassName("drawerMenu-Profession");

        let openSidebar = function () {
            sidebarOverlay.style.left = "0";
            sidebar.style.right = "0";
        };

        let closeSidebar = function (e) {
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

    function drawerCloseSidebar(){

        $('.sidebar-overlay-form').css('left','-100%')
        $('.dropSide-candidate-form').css('right','-100%')
    };

</script>
@endpush