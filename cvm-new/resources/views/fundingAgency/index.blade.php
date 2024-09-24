@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
      <div class="title">FUNDING AGENCIES</div>
      <div class="row">
      <div class="col-4">
        <div id="category">
        <x-form action="{{ route('funding-agency.store') }}" method="post">
        <x-input-component name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Agency Name">
        <x-error-component type="validation" :message="$errors->first('name')" />
        </x-input-component>
        <x-button-component type="submit" class="btn_style" label="Submit" />
        </x-form>
      </div>
      </div>

      <div class="col-8">
          <div class="table__wrapper">
          <table class="table funding_agency_datatable">
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
  $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.funding_agency_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('funding-agency.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function deleteFundingAgency(e) {
    var url = '{{ route("funding-agency.destroy", ":id") }}';
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
                        $('.funding_agency_datatable').DataTable().ajax.reload();
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