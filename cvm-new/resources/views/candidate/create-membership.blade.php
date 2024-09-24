<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-form" id="drawerMenu-member">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawerMembership">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                Add Membership Details
            </div>
            <div class="form_wrapper">
                <form id="submitCandidateMembership" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Membership<span class="reqText">*</span></label>
                                <select name="membership_id" >
                                    <option value="" selected>Select option</option>
                                    @foreach ($memberships as $membership)
                                        <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Membership Number<span class="reqText">*</span></label>
                                <input type="number" name="membership_number" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Year of Awarded<span class="reqText">*</span></label>
                                <input type="text" class="form-control datepicker" name="year_of_award" placeholder="select year..."  />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Type of Membership<span class="reqText">*</span></label>
                                <select name="type">
                                    <option value="" selected>Select option</option>
                                    <option value="Lifetime">Lifetime</option>
                                    <option value="Temporary">Temporary</option>
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

    if ($("#submitCandidateMembership").length > 0) {
        $("#submitCandidateMembership ").validate({
        rules: {
            membership_id: {
                required: true,
            },
            membership_number: {
                required: true,
            },
            year_of_award: {
                required: true,
            },
            type: {
                required: true,
            },
        },
        submitHandler: function(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = '{{ route("candidate-membership.store") }}';
        $.ajax({
            url: url ,
            type: "POST",
            data: $('#submitCandidateMembership').serialize(),
            success: function( response ) {
                $('#submitCandidateMembership').trigger("reset");
                drawerCloseSidebar();
                $('.membershipDatatable').DataTable().ajax.reload();
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
    let sidebar = document.getElementById("drawerMenu-member");
    let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
    let sidebarBtnClose = document.getElementById("closeDrawerMembership");
    let sidebarBtnOpen = document.getElementsByClassName("drawerMenu-member");

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

    $(".datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

</script>
@endpush