@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
      <div class="title">Language Setting</div>
      <div class="row">
      <div class="col-4">
        <div id="language">
        <form action="{{ route('language-setting.store') }}" method="post">
          @csrf
          <div class="add__option">
            <div class="input_grp">
              <label for="">Language Name</label>
              <input type="text" name="name"  value="{{old('name')}}" placeholder="type here..." />
              @if ($errors->has('name'))
              <span class="text-danger text-left">{{ $errors->first('name') }}</span>
          @endif
            </div>
          </div>

          <!-- ./add__option -->
          <div class="button_flex">
            <button type="submit" class="btn_style" id="toasted_btn">Save</button>
            <button type="reset" class="btn_style ghost_btn">Cancel</button>
          </div>
      </div>
      </div>

      <div class="col-8">
          <div class="table__wrapper">
          <table class="table language_datatable">
              <thead>
              <tr>
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

    var table = $('.language_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('language-setting.index') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action'},
        ]
    });
  });


  function deleteLanguage(e) {
    var url = '{{ route("language-setting.destroy", ":id") }}';
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
                        $('.language_datatable').DataTable().ajax.reload();
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