@foreach ($roles as $ks => $role)

@if($role->name === 'super-admin' || $role->name === 'system-admin')

    <tr>
        <th scope="row">{{$ks+1}}</th>
        <td>{{$role->name}}</td>
        <td>
            <div class="infoDetText">
                Default role can not be deleted.
            </div>
        </td>
    </tr>
@elseif($role->name == 'admin' || $role->name == 'employee')
<tr>
    <th scope="row">{{$ks+1}}</th>
    <td>{{$role->name}}</td>
    <td>
        <div class="reset_action">
            <div class="infoDetText">
                Default role can not be deleted.
            </div>
            <div class="reset_button" onclick="resetPermissions({{$role->id}})">
                <svg width="14" height="14" viewBox="0 0 24 24"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 4V10H7" stroke="#79868e" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M23 20V14H17" stroke="#79868e" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M20.49 9.00008C19.9828 7.56686 19.1209 6.28548 17.9845 5.27549C16.8482 4.26551 15.4745 3.55984 13.9917 3.22433C12.5089 2.88883 10.9652 2.93442 9.50481 3.35685C8.04437 3.77928 6.71475 4.56479 5.64 5.64008L1 10.0001M23 14.0001L18.36 18.3601C17.2853 19.4354 15.9556 20.2209 14.4952 20.6433C13.0348 21.0657 11.4911 21.1113 10.0083 20.7758C8.52547 20.4403 7.1518 19.7346 6.01547 18.7247C4.87913 17.7147 4.01717 16.4333 3.51 15.0001"
                        stroke="#79868e" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Reset Permissions
            </div>
        </div>
    </td>
</tr>
@else
<tr>
    <th scope="row">{{$ks+1}}</th>
    <td>{{$role->name}}</td>
    <td>
        <div class="reset_action">
            <div class="reset_button delete_btn" onclick="deleteRole({{$role->id}})">
                <svg width="14" height="14" viewBox="0 0 24 24"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6H5H21" stroke="#79868e" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6"
                        stroke="#79868e" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Delete
            </div>
        </div>
    </td>
</tr>
@endif
@endforeach