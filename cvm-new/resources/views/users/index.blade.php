@extends('layouts.app')

@section('content')
<main class="employee_wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="title">Employee List</div>
                @can('employee.add')
                <a href="{{ route('users.create')}}" class="btn_style">
                    <img src="{{ asset('images/icons/icons8-manage-48.png')}}" alt="">
                    Add Employee
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
                                    <a href="{{route('users.index')}}">
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
                                                Gender
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
                                                <select name="gender" id="gender" class="gender">
                                                    <option value="" selected>select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
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
                                            <button class="btn btn-link btn-block text-left " type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                Department
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
                                                <select name="department_id" id="" class="department">
                                                    <option value="" selected>Please select..</option>
                                                    @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Status
                                            </button>
                                            <img src="{{asset('images/icons/select-drop.png')}}" />
                                        </div>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <select name="is_active" class="status">
                                                    <option value="" selected>Please select..</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseFour"
                                                aria-expanded="false" aria-controls="collapseFour">
                                                Role
                                            </button>
                                            <img src="{{asset('images/icons/select-drop.png')}}" />
                                        </div>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <select name="role_id" id="" class="role">
                                                    <option value="" selected>Please select..</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                        <table class="table userDatatable  w-100">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" id="selectAll" />
                                    </th>
                                    <th scope="col" width="15%">Employee Id</th>
                                    <th scope="col" width="16%">Name</th>
                                    <th scope="col" width="20%">Email</th>
                                    <th scope="col" width="20%">Gender</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" width="15%">Action</th>
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
        <!-- ./container -->
    </section>
</main>

{{-- @include('users.edit') --}}
@endsection
@push('scripts')

<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.userDatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users.index') }}",
            data: function(d) {
                    d.gender = $('.gender').val(),
                    d.department_id = $('.department').val(),
                    d.is_active = $('.status').val(),
                    d.role_id = $('.role').val()
            }
        },
        columns: [{
                data: 'checkbox',
                name: 'checkbox'
            },
            {
                data: 'employee_id',
                name: 'employee_id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'role',
                name: 'role'
            },
            {
                data: 'is_active',
                name: 'is_active'
            },
            {
                data: 'action',
                name: 'action'
            },
        ]
    });
    $('.gender').on('change', function() {
        table.draw();
    });
    $('.department').on('change', function() {
        table.draw();
    });
    $('.status').on('change', function() {
        table.draw();
    });
    $('.role').on('change', function() {
        table.draw();
    });
});

$('body').on('click', '.deleteEmployee', function() {

    var id = $(this).data("id");
    var url = '{{ route("users.destroy", ":id") }}';
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
                        $('.userDatatable').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'Your file has been deleted.',
                            'success')
                    }
                }
            })
        }
    })
});
</script>
@endpush