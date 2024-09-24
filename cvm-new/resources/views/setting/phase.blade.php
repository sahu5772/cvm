@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Phase</div>
        <div class="row">
            <div class="col-4">
                <div id="sector">
                    <form action="{{ route('phase.store') }}" method="post">
                        @csrf
                        <div class="add__option">
                          <div class="input_grp">
                            <label for="">Industry Name</label>
                            <select name="industry_id" id="industry">
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
                            <select name="sector_id" id="sector-data">
                            </select>
                            @error('sector_id')
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="input_grp">
                            <label for="">Phase Name</label>
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
                <table class="table phase-datatable">
                    <thead>
                    <tr>
                        <th scope="col" width="18%">Sr No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Industry</th>
                        <th scope="col">Sector</th>
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

        var table = $('.phase-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('phase.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'industry', name: 'industry'},
                {data: 'sector', name: 'sector'},
                {data: 'action', name: 'action'},
            ]
        });
    });

    function deletePhase(e) {
        var url = '{{ route("phase.destroy", ":id") }}';
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
                            $('.phase-datatable').DataTable().ajax.reload();
                            Swal.fire('Deleted!','Your file has been deleted.',
                            'success')
                            }
                    }
                })
            }
        })
    }

    $('#industry').on('change', function () {

        var id = this.value;

        $.ajax({
            url: "{{url('sector-list')}}",
            type: "POST",
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#sector-data').html('<option value=""> Select Option </option>');
                $.each(result.sector, function (key, value) {
                    console.log(key, value);
                    $("#sector-data").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                // $('#sector-data').append();
            }
        });
    });
</script>
@endpush