@forelse($data as $k => $value)
<tr>
<td>{{ $k+1 }}</td>
<td>{{$value->name}}</td>
<td>{{$value->is_active}}</td>
<td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteValue({{$value->id}})" >Delete</a></td>
</tr>
@empty
<tr>
    <td colspan="3">no record found</td>
</tr>
@endforelse