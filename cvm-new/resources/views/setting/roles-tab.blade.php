
    <div class="tab-pane fade" id="{{$roles->name}}" role="tabpanel" aria-labelledby="{{$roles->name}}-tab">
    @foreach ($permissionData as $ks => $permissions)
    <div class="permissions_access_wrap">
        <div class="page_permission">
            <div class="title">{{ucfirst($ks)}}</div>
            <div class="rp_list">
                @foreach ($permissions as $kss => $permission)
                <div class="rp_item">
                    <div class="switch_button">
                        @php
                        $data = DB::table('role_has_permissions')->where('permission_id',$permission->id)->first();
                        $role_name = explode('.',$permission->name);
                        @endphp
                        <div>{{ucfirst($role_name[1])}}</div>
                        <label class="switch">
                            <input type="hidden" name="role_type" class="role_type" value=""/>
                            <input type="checkbox" name="permission[]" class="permission-data" value="{{$permission->id}}"/>
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