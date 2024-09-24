@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
      <div class="title">Category</div>
      <div class="row">
      <div class="col-4">
        <div id="category">
        <x-form action="{{ route('category.store') }}" method="post">
        <x-input-component name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Category Name">
        <x-error-component type="validation" :message="$errors->first('name')" />
        </x-input-component>
        <x-button-component type="submit" class="btn_style" label="Submit" />
        </x-form>
      </div>
      </div>

      <div class="col-8">
          <div class="table__wrapper">
          <table class="table category_datatable">
              <thead>
              <tr>
                  <th scope="col" width="18%">Sr No.</th>
                  <th scope="col">Name</th>
                  <th scope="col">Action</th>
                  <th scope="col" width="10%"></th>
              </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
          </div>
          <!-- ./table__wrapper -->
      </div>

      </div>
      <!-- ./row -->

      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">
                  <svg width="16" height="16" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M18 6L6 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  </span>
              </button>
              </div>
              <div class="modal-body">
                  <form id="categoryForm" name="categoryForm" class="form-horizontal" method="POST">
                  @method('patch')
                  @csrf
                  <input type="hidden" name="category_id" id="category_id" value="">
                  <div class="row">
                  <div class="col-sm-12">
                      <div class="input_grp">
                      <label for="">Category Name <span class="reqText">*</span></label>

                      <input type="text" name="name" id="name" value="" placeholder="Enter Category ...">
                      </div>
                      <!-- ./input_grp -->
                  </div>
                  </div>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn_style ghost_btn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn_style" id="saveBtn">Save changes</button>

              </div>
          </form>
          </div>
          </div>
      </div>
    </section>
</main>
@endsection
@push('scripts')
<script>
   if ($("#categoryForm").length > 0) {

    $("#categoryForm").validate({

    rules: {
      name: {
        required: true,
        maxlength: 50
      },
    },
    messages: {

      name: {
        required: "Please enter name",
        maxlength: "Your last name maxlength should be 50 characters long."
      },
    },
    submitHandler: function(form) {
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      var id = $('#category_id').val();
      var url = '{{ route("category.update", ":id") }}';
      url = url.replace(':id', id);

      $.ajax({
        url: url ,
        type: "POST",
        data: $('#categoryForm').serialize(),
        success: function( response ) {
            $('#categoryForm').trigger("reset");
            $('#res_message').fadeIn().html(
              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
            $('#editModal').modal('hide');
            setTimeout(function(){
                $('#res_message').fadeIn().fadeOut();
                $('.category_datatable').DataTable().ajax.reload();
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

<script>
  $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.category_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('category.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function editCategory(id) {
    var url = '{{ route("category.edit", ":id") }}';
        url = url.replace(':id', id);
        console.log(url);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'GET',
      url  : url,
      data : ({id : id,title :'edit'}),
      dataType: 'JSON',
      success: function(response) {
        $('#name').val(response.data.name);
        $('#category_id').val(response.data.id);
        $('#editModal').modal();
        // $('#myModal').modal('show');

      }
    });

  }

  function deleteCategory(e) {
    var url = '{{ route("category.destroy", ":id") }}';
        url = url.replace(':id', e);

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
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
                  type   : "delete",
                  success: function(data) {
                        if (data.success) {
                        $('.category_datatable').DataTable().ajax.reload();
                        Swal.fire('Deleted!','Your file has been deleted.',
                        'success')
                        }
                  }
              })
          }
      })
  }
</script>
@endpush