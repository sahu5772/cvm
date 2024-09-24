
<div class="modal fade" id="candidateCv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Candidate CV</h5>
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
            </div><br>

            <div class="modal-body">

            <form id="candiateCvForm" name="candiateCvForm" class="form-horizontal" method="POST"
                enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <input type="hidden" name="candidate_id" value="" id="candidate_idd"/>
                                <label for="">Candidate CV file<span class="reqText">*</span></label>
                            </div>
                            <input type="file" name="file" value="{{ old('file')}}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn_style">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
@push('scripts')
    <script>
        $("#candiateCvForm").validate({
            rules: {
                file: {
                    required: true,
                },
            },
        })

        $('#candiateCvForm').on('submit', function(event) {
            if ($("#candiateCvForm").valid()) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('candidate-cv.store') }}',
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            $('#candiateCvForm').trigger("reset");
                            $('#candidateCv').modal('hide');
                            var link = '<a href="' + "{{ route('candidate-cv.show', '') }}/" + response.candidate.id + '">' + response.candidate.file + '</a>';
                            $("#myDropdownfunction").append(link);
                        $('#res_message').fadeIn().html(
                            '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                            +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                            $('.company_datatable').DataTable().ajax.reload();
                            setTimeout(function() {
                                $('#res_message').fadeOut("Slow");
                            }, 2000);
                        } else {
                            $.each(response.error, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').after(
                                    '<label class="error" for="company_name">' + error +
                                    '</label>')
                            })
                        }
                    }
                })
            }
        });



        function uploadCv(id) {
                    $('#candidate_idd').val(id);
                    $('#candidateCv').modal('show');

        }

    </script>

@endpush
