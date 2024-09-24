<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-form" id="drawerMenu-training">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawerTraining">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                Add Training Details
            </div>
            <div class="form_wrapper">
                <form id="submitCandidateTraining" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Training/Certification<span class="reqText">*</span></label>
                                <select name="certificate_id" >
                                    <option value="" selected>Select option</option>
                                    @foreach ($certificates as $certificate)
                                        <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Institute/Training Center<span class="reqText">*</span></label>
                                <input type="text" name="training_center" placeholder="type here..." />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Year of Completion<span class="reqText">*</span></label>
                                <input type="text" class="form-control datepicker" name="year_of_completion" placeholder="select year..."  />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Duration<span class="reqText">*</span></label>
                                <input type="number" name="duration" placeholder="type here..." />
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
        let sidebar = document.getElementById("drawerMenu-training");
        let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
        let sidebarBtnClose = document.getElementById("closeDrawerTraining");
        let sidebarBtnOpen = document.getElementsByClassName(" drawerMenu-training");

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

    $(".datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    if ($("#submitCandidateTraining").length > 0) {
        $("#submitCandidateTraining ").validate({
            rules: {
                certificate_id: {
                    required: true,
                },
                training_center: {
                    required: true,
                },
                year_of_completion: {
                    required: true,
                },
                duration: {
                    required: true,
                },
            },
            submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = '{{ route("candidate-training.store") }}';
            $.ajax({
                url: url ,
                type: "POST",
                data: $('#submitCandidateTraining').serialize(),
                success: function( response ) {
                    $('#submitCandidateTraining').trigger("reset");
                    drawerCloseSidebar();
                    $('.candidateTraining').DataTable().ajax.reload();
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
        $('.dropSide-candidate-form').css('right','-100%')
    };
</script>
@endpush