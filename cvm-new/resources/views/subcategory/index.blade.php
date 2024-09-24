@extends('layouts.app')
@section('content')
<main class="master__wrapper">
@include('layouts.sidemenu')

<section class="inner__wrapper">
    <div class="title">Sub Category</div>
    <div class="row">
    <div class="col-4">
        <div id="category">
          <x-form action="{{ route('sub-category.store') }}" method="post">
            <x-input-component name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Category Name">
            <x-error-component type="validation" :message="$errors->first('name')" />
            </x-input-component>
            <x-select-input-component name="job_category_id" :options="$category" title="Select Category">
              <x-error-component type="validation" :message="$errors->first('job_category_id')" />
            </x-select-input-component>
            <x-button-component type="submit" class="btn_style" label="Submit" />
           </x-form>
        </div>
    </div>
    <div class="col-8">
        <div class="table__wrapper">
        <table class="table sub_category_datatable">
            <thead>
            <tr>
                <th scope="col" width="18%">Sr No.</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
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
              {{-- <x-form action="javascript:void(0)" method="POST" id="subCategoryForm" name="subCategoryForm">
                <x-input-component name="sub_category_id" type="hidden"  value="" id="sub_category_id" placeholder="Enter Category Name"/>

                <x-input-component name="name"  type="text" value="" id="name" title="Name" placeholder="Enter Category Name">
                <x-error-component type="validation" :message="$errors->first('name')" />
                </x-input-component>
                <x-select-input-component name="job_category_id" :options="$category" title="Select Category" id="job_category_id">
                  <x-error-component type="validation" :message="$errors->first('job_category_id')" />
                </x-select-input-component>
                <x-button-component type="submit" class="btn_style" label="Submit" />
               </x-form> --}}

               <form name="subCategoryForm" id="subCategoryForm" class="form-horizontal" method="POST">
                @method('patch')
                @csrf
                <input type="hidden" name="sub_category_id" id="sub_category_id" value="">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input_grp">
                            <label for="">Name <span class="reqText">*</span></label>
                            <input type="text" name="name" id="name" value=""
                            placeholder="Enter Category Name">
                        </div>
                        <div class="input_grp">
                            <label for="">Select Category <span class="reqText">*</span></label>
                            <select class="form-control" name="job_category_id" id="job_category_ids">
                            </select>
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
  if ($("#subEditCategoryForm").length > 0) {
     $("#subEditCategoryForm").validate({
     rules: {
       name: {
         required: true,
         maxlength: 50
       },
       job_category_id:{
        required:true,
       }
     },
     messages: {
       name: {
         required: "Please enter name",
         maxlength: "Your last name maxlength should be 50 characters long."
       },
       job_category_id: {
         required: "Please select category",
       },
     },
     submitHandler: function(form) {
        form.submit();
     }
   })
 }

    if ($("#subCategoryForm").length > 0) {
    $("#subCategoryForm").validate({
     rules: {
       name: {
         required: true,
         maxlength: 50
       },
       job_category_id:{
        required:true,
       }
     },
     messages: {
       name: {
         required: "Please enter name",
         maxlength: "Your last name maxlength should be 50 characters long."
       },
       job_category_id: {
         required: "Please select category",
       },
     },
     submitHandler: function(form) {
      $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       var id = $('#sub_category_id').val();
       var url = '{{ route("sub-category.update", ":id") }}';
       url = url.replace(':id', id);
       $.ajax({
         url: url ,
         type: "POST",
         data: $('#subCategoryForm').serialize(),
         success: function( response ) {
             $('#subCategoryForm').trigger("reset");
             $('#editModal').modal('hide');

             $('#res_message').fadeIn().html(
              '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');

             setTimeout(function(){
              $('#res_message').fadeIn().fadeOut();
                $('.sub_category_datatable').DataTable().ajax.reload();
          
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

<script type="text/javascript">
  $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.sub_category_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sub-category.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'category', name: 'category'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function editSubCategory(id) {
    var url = '{{ route("sub-category.edit", ":id") }}';
        url = url.replace(':id', id);
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
        $('#sub_category_id').val(response.data.id);
        // $("#job_category_id").empty();
        var len = 0;
            if(response['category'] != null){
                len = response['category'].length;
            }
            if(len > 0){
                for(var i=0; i<len; i++){
                    var id = response['category'][i].id;
                    var name = response['category'][i].name;
                    if(response.sub_cat_id == id){
                    var option = "<option value='"+id+"' selected>"+name+"</option>";
                    }else{
                        var option = "<option value='"+id+"'>"+name+"</option>";
                    }
                    $("#job_category_ids").append(option);
                }
            }
        $('#editModal').modal();
      }
    });

  }
    function deleteSubCategory(e) {
    var url = '{{ route("sub-category.destroy", ":id") }}';
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
                        $('.sub_category_datatable').DataTable().ajax.reload();
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