
<div class="modal fade" id="jobTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Job Type</h5>
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
            <form id="jobTypeForm" name="jobTypeForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input_grp">
                            <label for="name">Job Type Name <span class="reqText">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Enter Your Job Type Name" autocomplete="off" />
                        </div>
                        <label class="error" for="name"></label> <!-- Display validation error message here -->
                    </div>
                </div>
            </form>
            <div class="addcompany__wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="job-type-datatable-value">
                        <!-- Your table data here -->
                    </tbody>
                </table>
            </div>
            <!-- ./table__wrapper -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn_style ghost_btn" data-dismiss="modal">Close</button>
            <button type="button" id="submitjobTypeForm" class="btn_style">Submit</button>
        </div>
    </div>
</div>
</div>


@push('scripts')
<script>
$(document).ready(function () {
        $("#jobtype").click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: '{{ route('job-type.index') }}',
                dataType: 'JSON',
                success: function(response) {
                    $('#job-type-datatable-value').html(response.data);
                    $("#jobTypeModal").modal("show");
                }
            });
        });
    });
    $(document).ready(function () {
        if ($("#jobTypeForm").length > 0) {
            $("#jobTypeForm").validate({
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

                    $("#submitjobTypeForm").attr("disabled", true);

                    $.ajax({
                        url: '{{ route('job-type.store') }}',
                        type: "POST",
                        data: $('#jobTypeForm').serialize(),
                        success: function (response) {
                            if ($.isEmptyObject(response.error)) {
                                $('#jobTypeForm').trigger("reset");
                                $('#res_message').fadeIn().html(
                                    '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                                    + response.message + '</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                                $('#jobTypeModal').modal('hide');
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
                            $("#submitjobTypeForm").attr("disabled", false);
                        }
                    });
                }
            });

            $("#submitjobTypeForm").on("click", function () {
                if ($("#jobTypeForm").valid()) {
                    $("#jobTypeForm").submit(); 
                }
            });
        }
    });

    function deleteValue(e) {
            var url = '{{ route('job-type.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this Job Type!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this Job Type!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('#job-type-datatable-value').html(data.data);
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