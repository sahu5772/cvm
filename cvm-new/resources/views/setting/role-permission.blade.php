@extends('layouts.app')
@section('content')
    <main class="rolePermissions_wrapper">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="title">Roles & Permissions</div>
                @hasrole(['system-admin', 'super-admin'])
                <a href="javascript:void(0)" onclick="roleData()" class="btn_style">
                    <img src="{{asset('/')}}images/icons/icons8-manage-48.png" alt="">
                    Manage Role
                </a>
                @endhasrole
            </div>

            <div class="roles_permission">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link">
                            <div class="text">
                                <div class="headText">
                                    @if(auth()->user()->hasRole('super-admin'))
                                        Super Admin
                                    @elseif(auth()->user()->hasRole('system-admin'))
                                        System Admin
                                    @endif
                                </div>
                                @if(auth()->user()->hasAnyRole(['super-admin', 'system-admin']))
                                    <div class="infoText">Admin permissions cannot be changed</div>
                                @endif
                            </div>
                            
                        </button>
                    </li>

                    @foreach ($data as $role)
                    @if ($role->name != 'super-admin')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="{{$role->name}}-tab" data-toggle="tab" data-target="#{{$role->name}}"
                                type="button" role="tab" aria-controls="{{$role->name}}" aria-selected="false" onclick="role_type({{$role->id}})">
                                <div class="text">
                                    <div class="headText">{{ ucfirst($role->name) }}</div>
                                    <span>
                                        <?= App\Models\User::where('company_id', Auth::user()->company_id)
                                            ->whereHas('roles', function ($query) use ($role) {
                                                $query->where('name', $role->name);
                                            })
                                            ->count(); 
                                        ?> Member
                                    </span>
                                </div>
                                <div class="permission_btn">
                                    <img src="{{ asset('images/icons/key.png') }}" alt="" />
                                    Permissions
                                </div>
                            </button>
                        </li>
                    @endif
                @endforeach


                </ul>

                <div class="tab-content" id="myTabContent">
                    @foreach ($data as $role)
                    <div class="tab-pane fade" id="{{$role->name}}" role="tabpanel">
                        @foreach ($permissionData as $ks => $permissions)
                            <div class="permissions_access_wrap">
                                <div class="page_permission">
                                    <div class="title">{{ ucfirst($ks) }}</div>
                                    <div class="rp_list">
                                        @foreach ($permissions as $kss => $permission)
                                            <div class="rp_item">
                                                <div class="switch_button">
                                                    @php
                                                        $data = DB::table('role_has_permissions')
                                                            ->where('permission_id', $permission->id)->where('role_id',$role->id)
                                                            ->first();
                                                        $role_name = explode('.', $permission->name);
                                                    @endphp
                                                    <div>{{ ucfirst($role_name[1]) }}</div>
                                                    <label class="switch">
                                                        <input type="hidden" name="role_type" class="role_type" value="" />
                                                        <input type="checkbox" name="permission[]" class="permission-data"
                                                            value="{{ $permission->id }}" @if(isset($data)) checked @endif />
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- ./rp_list -->
                                </div>
                            </div>
                        @endforeach
                        <!-- ./permissions_access_wrap -->
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="manageRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-keyboard="false" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Manage Role</h5>
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
                <div class="modal-body">
                    <form method="POST" id="RoleForm" name="RoleForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input_grp">
                                    <label for="">Role Name <span class="reqText">*</span></label>
                                    <input type="text" name="name" id="name"
                                        placeholder="Enter Role Name ..." autocomplete="off">
                                </div>
                                <!-- ./input_grp -->
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="input_grp">
                                    <label for="">Import from Role</label>
                                    <select name="" id="">
                                        <option value="" selected>Select option</option>
                                        <option value="civil">Civil</option>
                                        <option value="Metro">Metro</option>
                                        <option value="Test House">Test House</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                        <!-- ./row -->

                        <div class="table__wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">User Role</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="role_data_datatable">

                                </tbody>
                            </table>
                        </div>
                        <!-- ./table__wrapper -->
                        <div class="modal-footer">
                            <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn_style">Save changes</button>
                        </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>


        function role_type(id) {
            $('.role_type').val(id)
        }
        $(".permission-data").change(function () {
           var  role = $('.role_type').val();
           var permission_id = this.value;
              $(".city").html('');
              $.ajax({
                  url: "{{route('permission-store')}}",
                  type: "POST",
                  data: {
                      permission_id: permission_id,
                      role_id: role,
                      _token: '{{csrf_token()}}'
                  },
                  dataType: 'json',
                  success: function (response) {
                    $('#res_message').fadeIn().html(
                    '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                    +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                    setTimeout(function() {
                    $('#res_message').fadeOut("Slow");
                    }, 4000);
                  }
              });
        });

            if ($("#RoleForm").length > 0) {
                $("#RoleForm").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 50
                        },
                    },
                    messages: {
                        name: {
                            required: "Please enter role name",
                            maxlength: "Your name maxlength should be 50 characters long."
                        },
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: '{{ route('role.store') }}',
                            type: "POST",
                            data: $('#RoleForm').serialize(),
                            success: function(response) {
                                if (response.status) {
                                    $('#RoleForm').trigger("reset");
                                    $('#res_message').fadeIn().html(
                                    '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                                    +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                                    $('#manageRoleModal').modal('hide');
                                    $('#res_message').fadeIn().delay(3000).fadeOut();
                                     setTimeout(function() {
                                        location.reload();
                                     }, 4000);
                                } else {
                                $('#res_message').fadeIn().html(
                                '<div class="toast active"><div class="toast-content"><i class="fa fa-times-circle text-danger" style="font-size:48px;color:red"></i><div class="message"><span class="text text-2 text-danger">'
                                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                                setTimeout(function() {
                                $('#res_message').fadeOut();
                                }, 2000);
                                $(document).find('[id=name]').after('<label class="error" for="name">' +error + '</label>')
                                }
                            },
                            error: function(response) {
                                // console.log('Error:', response.error);
                            }
                        });
                    }
                });
            }

            function roleData() {
            var url = '{{ route('roles') }}';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'JSON',
                success: function(response) {
                    $('#role_data_datatable').html(response.roles);
                    $('#manageRoleModal').modal('show');
                }
            });

        }

        function deleteRole(e) {
            var url = '{{ route('role.destroy', ':id') }}';
            url = url.replace(':id', e);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Are you sure to delete this role !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete this role!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(response) {
                            if (response.success) {
                                $('#role_data_datatable').html(response.roles);
                                Swal.fire('Deleted!', 'Your file has been deleted.',
                                    'success')
                            }
                        }
                    })
                }
            })
        }
        function resetPermissions(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Reset",
                text: "Are you sure you whan to reset permision",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Reset permisison this role!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                            url: "{{route('resetPermission')}}",
                            type: "POST",
                            data: {
                            role_id: e,
                            _token: '{{csrf_token()}}'
                            },
                        success: function(response) {
                            if (response.success) {
                                $('#role_data_datatable').html(response.roles);
                                Swal.fire('Deleted!', 'Your file has been deleted.',
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
