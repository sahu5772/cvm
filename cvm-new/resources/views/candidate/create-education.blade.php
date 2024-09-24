<div class="sidebar-overlay-form"></div>
<div class="dropSide-candidate-form" id="drawerMenu-education">
    <div class="btn__close" id="drawerClose">close</div>
    <!-- ./btn__close -->
    <main class="addEducational_wrapper">
        <div class="container">
            <div class="title title_wrapper">
                <div class="arrow_back" id="closeDrawer">
                    <img src="{{ asset('images/icons/crossed.png')}}" width="10">
                </div>
                {{ __('messages.add')}} {{ __('messages.candidate.educational_details')}}
            </div>

            <div class="form_wrapper">
                <form id="submitEducationForm" method="post">
                    @csrf
                    <input type="hidden" value="{{request()->segment(2)}}" name="candidate_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">{{ __('messages.qualification')}}<span class="reqText">*</span></label>
                                <select name="educational_level_id" id="">
                                    <option value="" selected>{{ __('messages.select_option')}}</option>
                                    @foreach ($qualifications as $qualification)
                                    <option value="{{ $qualification->id}}">{{ $qualification->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">{{ __('messages.subject')}}<span class="reqText">*</span></label>
                                <select name="subject_id" id="">
                                    <option value="" selected>{{ __('messages.select_option')}}</option>
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id}}">{{ $subject->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Specialization <span class="reqText">*</span></label>
                                <input type="text" name="specialization" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">Institue/University<span class="reqText">*</span></label>
                                <select name="university_id" id="">
                                    <option value="" selected>{{ __('messages.select_option')}}</option>
                                    @foreach ($universities as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">From Date<span class="reqText">*</span></label>
                                <input type="text" name="from_year" placeholder="type here..." class="datepicker"/>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">To Date<span class="reqText">*</span></label>
                                <input type="text" name="to_year" placeholder="type here..." class="datepicker1"/>
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">{{ __('messages.percentage')}} <span class="reqText">*</span></label>
                                <input type="number" name="percentage" placeholder="type here..." />
                            </div>
                            <!-- ./input_grp -->
                        </div>
                        <div class="col-sm-6">
                            <div class="input_grp">
                                <label for="">{{ __('messages.candidate.mode_of_study')}}<span
                                        class="reqText">*</span></label>
                                <select name="education_mode_id" id="">
                                    <option value="" selected>{{ __('messages.select_option')}}</option>
                                    @foreach ($educationModes as $educationMode)
                                    <option value="{{ $educationMode->id }}">{{ $educationMode->name }}</option>
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
                        <button type="submit" id="submitEducationButton" class="btn_style">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- container -->
    </main>
</div>

@push('scripts')

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

    if ($("#submitEducationForm").length > 0)
    {
        $("#submitEducationForm").validate({
          rules: {
            specialization: {
              required: true,
              maxlength: 50
            },
            educational_level_id: {
              required: true,
            },
            subject_id: {
              required: true,
            },
            university_id: {
              required: true,
            },
            from: {
              required: true,
            },
            to: {
              required: true,
            },
            percentage: {
              required: true,
            },
            education_mode: {
              required: true,
            },
          },
          messages: {
            specialization: {
              required: "Please enter specialization",
              maxlength: "Your last specialization maxlength should be 50 characters long."
            },
            educational_level_id: {
              required: "Please enter qualification",
            },
            subject_id: {
              required: "Please enter subject",
            },
            university_id: {
              required: "Please enter university",
            },
            from_year: {
              required: "Please enter from date",
            },
            to_year: {
              required: "Please enter to date",
            },
            percentage: {
              required: "Please enter percentage",
            },
            education_mode: {
              required: "Please enter education mode",
            },
          },
          submitHandler: function(form) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = '{{ route("candidate-education.store") }}';
            $.ajax({
              url: url ,
              type: "POST",
              data: $('#submitEducationForm').serialize(),
              success: function( response ) {
                  $('#submitEducationForm').trigger("reset");
                  drawerCloseSidebar();
                  $('.educationDatatable').DataTable().ajax.reload();
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

    // =========== Drawer form educational
    (function() {
        let sidebar = document.getElementById("drawerMenu-education");
        let sidebarOverlay = document.getElementsByClassName("sidebar-overlay-form")[0];
        let sidebarBtnClose = document.getElementById("closeDrawer");
        let sidebarBtnOpen = document.getElementsByClassName("drawerMenu-education");

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
</script>
@endpush