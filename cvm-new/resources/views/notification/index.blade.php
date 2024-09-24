@extends('layouts.app')
@section('content')
<main class="master__wrapper">
    @include('layouts.sidemenu')

    <section class="inner__wrapper">
        <div class="title">Notification</div>

            <div class="row">
                <div class="col-12">

                    <div class="table__wrapper">
                        <table class="table notification_datatable">
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

    var table = $('.notification_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('notification.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'type', name: 'type'},
            {data: 'data', name: 'data'},
            {data: 'action', name: 'action'},
        ]
    });
  });
</script>
@endpush