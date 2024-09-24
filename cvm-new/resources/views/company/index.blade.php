@extends('layouts.app')
@section('content')
<main class="company_wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="title">Company List</div>
            @can('company.add')
            <a href="{{ route('company.create') }}" class="btn_style">
            <img src="{{asset('/')}}images/icons/icons8-manage-48.png" alt="">
            Add Company
            </a>
            @endcan
        </div>
        <!-- ./heading -->

        <div class="row">
        <div class="col-3 candidate_filter">
                    <div class="general_filter">
                        <div class="first-filter-header">
                            <h3 class="general-filters-cont">Filters
                                <div class="notification">
                                    <a href="{{route('company.index')}}">
                                    <img src="{{asset('/images/icons/undo-arrow.png')}}" width="20" alt="">
                                    </a>
                                </div>
                            </h3>
                        </div>
                        <div class="accordion" id="accordionExample">
                            {{-- <div class="filter-search">
                                <div class="search_wrap">
                                    <img src="{{asset('images/icons/search.png')}}" alt="">
                                    <input type="text" placeholder="Search here...">
                                </div>
                            </div> --}}
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
                                                <select name="is_active" id="is_active">
                                                    <option value="" selected>Please Select Status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option value="License Expired">License Expired</option>
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
                                                Educational Details
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
                                                <select name="license_by" id="license_by">
                                                    <option value="" selected>License By</option>
                                                    <option value="company">company</option>
                                                    <option value="user">user</option>
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
                <table class="table company_datatable display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Website</th>
                            <th scope="col" width="18%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                {{-- <p class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </p> --}}
                </form>
            </div>
            <!-- ./table__wrapper -->
            </div>
        </div>
        <!-- ./row -->
        </div>
        <!-- ./container -->
    </section>
    @include('business.business-unit');
    </main>
@push('scripts')
<script>
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
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.company_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('company.index') }}",
                data: function(d) {
                    d.license_by = $('#license_by').val(),
                    d.is_active = $('#is_active').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                // {"data": "checkbox", orderable:false, searchable:false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'website', name: 'website'},
                {data: 'action', name: 'action'},
            ]
        });
        $('#license_by').on('change', function() {
            table.draw();
        });
        $('#is_active').on('change', function() {
            table.draw();
        });

    });

    $(document).ready(function() {
        // Initialize the "Select All" checkbox
        $('#selectAll').click(function() {
            $('input[type="checkbox"]').prop('checked', this.checked);
            $("#btn-submit").toggle();
        });
    });

    function checkSelectRow() {
        $("#btn-submit").toggle();
    }

    function deleteCompany(e) {
        var url = '{{ route("company.destroy", ":id") }}';
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
                            $('.company_datatable').DataTable().ajax.reload();
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
@endsection