<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-form" id="drawerMenu-address">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawerAddress">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                Add Adresss
            </div>
            <div class="form_wrapper">
                <form id="candidateAddress" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Address<span class="reqText">*</span></label>
                                <input type="text" name="address" placeholder="type here..." />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Country<span class="reqText">*</span></label>
                                <select name="country_id" class="country">
                                    <option value="" selected>Select option</option>
                                    @foreach ($countries as $country )
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">State<span class="reqText">*</span></label>
                                <select name="state_id" class="state">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">City<span class="reqText">*</span></label>
                                <select name="city_id" class="city"></select>
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

    // =========== Drawer form address
    (function() {
        let sidebar = document.getElementById("drawerMenu-address");
        let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
        let sidebarBtnClose = document.getElementById("closeDrawerAddress");
        let sidebarBtnOpen = document.getElementsByClassName("drawerMenu-address");

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

    function drawerCloseSidebar(){

        $('.sidebar-overlay-form').css('left','-100%')
        $('.dropSide-candidate-form').css('right','-100%')
    };

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

    if ($("#candidateAddress").length > 0) {
        $("#candidateAddress ").validate({
            rules: {
                address: {
                    required: true,
                    maxlength: 50
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
            },
            submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = '{{ route("candidate-address.store") }}';
            $.ajax({
                url: url ,
                type: "POST",
                data: $('#candidateAddress').serialize(),
                success: function( response ) {
                    $('#candidateAddress').trigger("reset");
                    drawerCloseSidebar();
                    $('.addressDatatable').DataTable().ajax.reload();
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
</script>
@endpush