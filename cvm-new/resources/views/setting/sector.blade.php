@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Sectors</div>
        <div class="row">
            <div class="col-4">
                <div id="sector">
                    <form action="{{ route('sector.store') }}" method="post">
                        @csrf
                        <div class="add__option">
                          <div class="input_grp">
                            <label for="">Industry Name</label>
                            <select name="industry_id">
                                <option value="" selected>Select option</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name}}</option>
                                @endforeach
                            </select>
                            @error('industry_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="input_grp">
                            <label for="">Sector Name</label>
                            <input type="text" name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Name" />
                            @error('name')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>
                        <!-- ./add__option -->
                        <div class="button_flex">
                          <button type="submit" class="btn_style">Save</button>
                          <button type="reset" class="btn_style ghost_btn">
                            Cancel
                          </button>
                        </div>
                      </form>
                </div>
            </div>

            <div class="col-8">
                <div class="table__wrapper">
                <table class="table sector-datatable">
                    <thead>
                    <tr>
                        <th scope="col" width="18%">Sr No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Industry</th>
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

    var table = $('.sector-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sector.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'industry', name: 'industry'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function deleteSector(e) {
    var url = '{{ route("sector.destroy", ":id") }}';
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
                            $('.sector-datatable').DataTable().ajax.reload();
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