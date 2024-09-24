@extends('layouts.app')
@section('content')
<main class="company_wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="title">Business Units</div>
                <a href="{{ route('business.create') }}" class="btn_style">
                <img src="{{asset('/')}}images/icons/icons8-manage-48.png" alt="">
                Add Business Unit
                </a>
            </div>
            <!-- ./heading -->

            <div class="row">
                <div class="col-3 candidate_filter">
                    <div class="general_filter">
                        <div class="first-filter-header">
                            <h3 class="general-filters-cont">Filters
                                <div class="notification">
                                    <a href="{{route('business.index')}}">
                                    <img src="{{asset('/images/icons/undo-arrow.png')}}" width="20" alt="">
                                    </a>
                                </div>
                            </h3>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Personal Details
                                            </button>
                                            <img src="{{asset('images/icons/select-drop.png')}}" />
                                        </div>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <select name="is_active" id="statusData">
                                                    <option value="" selected>Please Select Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                Other Details
                                            </button>
                                            <img src="{{asset('images/icons/select-drop.png')}}" />
                                        </div>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <label for="">Country</label>
                                                <select name="country_id" id="countryData">
                                                    <option value="" selected>Select Country</option>
                                                    @foreach ($countries as $country )
                                                        <option value="{{$country->id}}"> {{ ucfirst($country->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <label for="">Timezone</label>
                                                <select name="timezone_id" id="timezoneData">
                                                    <option value="" selected>Select Timezone</option>
                                                    @foreach ($timezones as $timezone )
                                                        <option value="{{$timezone->id}}"> {{ ucfirst($timezone->timezone)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="table__wrapper">
                        <form name="frm-example" id="frm-example">
                            <table class="table businessDatatable display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="18%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- ./table__wrapper -->
                </div>
            </div>
            <!-- ./row -->
        </div>
        <!-- ./container -->
    </section>
</main>

<div class="modal fade" id="viewBusinessModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Business details</h5>
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
            </div>
            <div id="businessDetail"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.businessDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: "{{ route('business.index') }}",
                        data: function(d) {
                            d.country = $('#countryData').val(),
                            d.timezone = $('#timezoneData').val(),
                            d.is_active = $('#statusData').val()
                        }
                    },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'country', name: 'country'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#countryData').on('change', function() {
                table.draw();
            });
            $('#timezoneData').on('change', function() {
                table.draw();
            });
            $('#statusData').on('change', function() {
                table.draw();
            });
        });

        $('body').on('click', '.deleteUnit', function() {

            var id = $(this).data("id");
            var url = '{{ route("business.destroy", ":id") }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: "Delete",
                text: "Do you realy want to delete!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this item!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            if (data.success) {
                                $('.businessDatatable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success')
                            }
                        }
                    })
                }
            })
        });

        function viewUnit(e) {
            var url = '{{ route("business.show", ":id") }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                type: "get",
                success: function(response) {
                    $('#businessDetail').html(response.data);
                    $("#viewBusinessModel").modal("show");
                }
            })
        }
    </script>
@endpush
