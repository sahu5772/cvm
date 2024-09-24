@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
      <div class="title">Universities</div>
      <div class="row">
      <div class="col-4">
        <div id="category">
        <x-form action="{{ route('university.store') }}" method="post">
        <x-input-component name="name"  value="{{old('name')}}" title="Name" placeholder="Enter Name">
        <x-error-component type="validation" :message="$errors->first('name')" />
        </x-input-component>
        <div class="row">
        <div class="col-sm-12">
            <div class="input_grp">
                <label for="">Country<span class="reqText">*</span></label>
                <select name="country_id" class="country">
                    <option value="" selected>Please select country</option>
                    @foreach ($country as $vs)
                        <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('country_id'))
                <span class="text-danger text-left">{{ $errors->first('country_id') }}</span>
                @endif
            </div>
            <!-- ./input_grp -->
        </div>
        <div class="col-sm-12">
            <div class="input_grp">
                <label for="">State<span class="reqText">*</span></label>
                <select name="state_id" class="state">
                </select>
                @if ($errors->has('state_id'))
                <span class="text-danger text-left">{{ $errors->first('state_id') }}</span>
                @endif
            </div>
            <!-- ./input_grp -->
        </div>
        <div class="col-sm-12">
            <div class="input_grp">
                <label for="">City<span class="reqText">*</span></label>
                <select name="city_id" class="city"></select>
                @if ($errors->has('city_id'))
                <span class="text-danger text-left">{{ $errors->first('city_id') }}</span>
                @endif
            </div>
            <!-- ./input_grp -->
        </div>
        </div>
        <x-button-component type="submit" class="btn_style" label="Submit" />
        </x-form>
      </div>
      </div>

      <div class="col-8">
          <div class="table__wrapper">
          <table class="table university-datatable">
              <thead>
              <tr>
                  <th scope="col" width="18%">Sr No.</th>
                  <th scope="col">Name</th>
                  <th scope="col">Country</th>
                  <th scope="col">State</th>
                  <th scope="col">City</th>
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

    var table = $('.university-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('university.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'country', name: 'country'},
            {data: 'state', name: 'state'},
            {data: 'city', name: 'city'},
            {data: 'action', name: 'action'},
        ]
    });
  });

  function deleteUniversity(e) {
    var url = '{{ route("university.destroy", ":id") }}';
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
                        $('.university-datatable').DataTable().ajax.reload();
                        Swal.fire('Deleted!','Your file has been deleted.',
                        'success')
                        }
                  }
              })
          }
      })
  }

  $(document).ready(function () {
            $('.country').on('change', function () {

                var idCountry = this.value;

                $(".state").html('');
                $.ajax({
                    url: "{{url('states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('.state').html('<option value="">-- Select State --</option>');
                        $.each(result.states, function (key, value) {
                            $(".state").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('.city').html('<option value="">-- Select City --</option>');
                    }
                });
            });

            $('.state').on('change', function () {
                var idState = this.value;
                $(".city").html('');
                $.ajax({
                    url: "{{url('cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('.city').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function (key, value) {
                            $(".city").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });
</script>
@endpush