@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
      <div class="title">Employee Type</div>
      <div class="row">
      <div class="col-4">
        <div id="category">
        <x-form action="{{ route('employee-type.store') }}" method="post">
        <x-input-component name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Name">
        <x-error-component type="validation" :message="$errors->first('name')" />
        </x-input-component>
        <x-button-component type="submit" class="btn_style" label="Submit" />
        </x-form>
      </div>
      </div>

      <div class="col-8">
          <div class="table__wrapper">
          <table class="table employee-type-datatable">
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

    var table = $('.employee-type-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee-type.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function deleteEmployeType(e) {
    var url = '{{ route("employee-type.destroy", ":id") }}';
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
                            $('.employee-type-datatable').DataTable().ajax.reload();
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