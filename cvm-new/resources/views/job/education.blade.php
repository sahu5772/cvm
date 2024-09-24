<div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Education Level</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="modal-body">
            <form id="educationForm" name="educationForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input_grp">
                            <label for="name">Education Level Name <span class="reqText">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Enter Education Level Name" autocomplete="off" />
                        </div>
                        <label class="error" for="name"></label> <!-- Display validation error message here -->
                    </div>
                </div>
            </form>
            <div class="addcompany__wrapper">
                <table class="table education-datatable">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="education-datatable-value">
                        <!-- Your table data here -->
                    </tbody>
                </table>
            </div>
            <!-- ./table__wrapper -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn_style ghost_btn" data-dismiss="modal">Close</button>
            <button type="button" id="submiteducationForm" class="btn_style">Submit</button>
        </div>
        
    </div>
</div>
</div>


@push('scripts')
<script>
$(document).ready(function () {
        $("#edulevel").click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: '{{ route('education.index') }}',
                dataType: 'JSON',
                success: function(response) {
                    $('#education-datatable-value').html(response.data);
                    $("#educationModal").modal("show");
                }
            });
        });
    });
$(document).ready(function () {
    if ($("#educationForm").length > 0) {
        $("#educationForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },
               
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    maxlength: "Name should be less than 50 characters"
                },
                
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.next("label"));
            },
            submitHandler: function (form) {
          
                $("#submiteducationForm").attr("disabled", true);

                $.ajax({
                    url: '{{ route('education.store') }}',
                    type: "POST",
                    data: $('#educationForm').serialize(),
                    success: function (response) {
                        if ($.isEmptyObject(response.error)) {
                            $('#educationForm').trigger("reset");
                            $('#res_message').fadeIn().html(
                                '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                                + response.message + '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                            $('#educationModal').modal('hide');
                            setTimeout(function () {
                                $('#res_message').fadeOut("slow");
                            }, 4000);
                        } else {
                            $.each(response.error, function (field_name, error) {
                                $(document).find('[name=' + field_name + ']').next("label").html(error);
                            })
                        }
                    },
                    error: function (response) {
                        console.log('Error:', response);
                    },
                    complete: function () {
                        // Re-enable the submit button
                        $("#submiteducationForm").attr("disabled", false);
                    }
                });
            }
        });

        $("#submiteducationForm").on("click", function () {
            if ($("#educationForm").valid()) {
                $("#educationForm").submit(); 
            }
        });
    }
});

    function deleteValue(e) {
            var url = '{{ route('education.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this education!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this education!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('#education-datatable-value').html(data.data);
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success')
                            }
                        }
                    })
                }
            })
        }

</script>
@endpush