@forelse($locations as $k => $value)
    <tr>
        <td>{{ $value->name }}</td>
        <td>{{ $value->address }}</td>
        <td>{{ $value->country->name }}</td>
        <td>{{ $value->state->name }}</td>
        <td>{{ $value->city->name }}</td>
        <td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteCompanyLocation({{$value->id}},{{$value->company_id}})" >Delete</a></td>
    </tr>
@empty
    <tr>
        <td colspan="3">No Record Found</td>
    </tr>
@endforelse