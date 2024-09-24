
<div class="modal fade" id="candidateCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Candiate Comment</h5>
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
                    <div class="addcompany__wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Contact Through</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Action</th>
                                    <th scope="col" width="18%"></th>
                                </tr>
                            </thead>
                            <tbody id="candidate_comment_datatable">
                            </tbody>
                        </table>
                    </div><br>
                    <!-- ./table__wrapper -->

            <form id="candiateCommentForm" name="candiateCommentForm" class="form-horizontal" method="POST"
                enctype="multipart/form-data">

                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="input_grp">
                                <input type="hidden" name="candidate_id" value="" id="candidate_id"/>
                                <label for="">Contact Through<span class="reqText">*</span></label>
                                <select name="contact_through" class="job-category" value="{{ old('contact_through') }}" id="job-category" onchange="showOtherOption(this)">
                                    <option value="" selected>Please select..</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" id="otherOptionDiv" style="display: none;">
                            <div class="input_grp">
                                <label for="">Other Option Name <span class="reqText">*</span></label>
                                <input type="text" name="other_option" value="{{ old('other_option') }}" id="other_option" placeholder="Enter your other option" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_grp">
                                <label for="">Comment <span class="reqText">*</span></label>
                                <input type="text" name="comment" value="{{ old('comment') }}" id="comment"
                                    placeholder="Enter your comment" autocomplete="off" />
                            </div>
                        </div>
                        <!-- ./row -->
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
        $("#candiateCommentForm").validate({
            rules: {
                comment: {
                    required: true,
                },
            },
            messages: {
                comment: {
                    required: "Please enter comment",
                },
            }
        })

        $('#candiateCommentForm').on('submit', function(event) {
            if ($("#candiateCommentForm").valid()) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('candidate-comment.store') }}',
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if ($.isEmptyObject(response.error)) {
                            $('#candiateCommentForm').trigger("reset");
                            $('#candidateCommentModal').modal('hide');
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



        function candidateComment(id) {
            var url = '{{ route('candidate-comment.show', ':id') }}';
            url = url.replace(':id', id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: url,
                data: ({
                    id: id,
                    title: 'comment'
                }),
                dataType: 'JSON',
                success: function(response) {
                    $('#candidate_comment_datatable').html(response.comments);
                    $('#candidate_id').val(id);
                    $('#candidateCommentModal').modal('show');
                }
            });

        }

function deleteCandiateComment(id) {
    var url = '{{ route('candidate-comment.destroy', ':id') }}';
    url = url.replace(':id', id);
      Swal.fire({
          title             : "Delete",
          text              : "Do you realy want to delete!",
          icon              : "warning",
          showCancelButton  : true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor : "#d33",
          confirmButtonText : "Yes, Delete this item!"
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url    : url,
                  type: "delete",
                  data: {
                      id: id,
                      _token: '{{csrf_token()}}'
                  },
                  success: function(response) {
                      console.log(response);
                        if (response.status) {
                        $('#candidate_comment_datatable').html(response.comments);
                        Swal.fire('Deleted!','Your file has been deleted.',
                        'success')
                        }
                  }
              })
          }
      })
  }

  function showOtherOption(selectElement) {
            var otherOptionDiv = document.getElementById("otherOptionDiv");
            var otherOptionInput = document.getElementById("other_option");

            if (selectElement.value === "other") {
                otherOptionDiv.style.display = "block";
                otherOptionInput.required = true;
            } else {
                otherOptionDiv.style.display = "none";
                otherOptionInput.required = false;
                otherOptionInput.value = "";
            }
        }
    </script>

@endpush
