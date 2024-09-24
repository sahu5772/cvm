@forelse($data as $k =>$value)
<tr>
<td>{{ $k+1 }}</td>
<td>{{$value->name}}</td>
<td>{{$value->is_active}}</td>
<td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteSkill({{$value->id}},{{$value->company_id}})" >Delete</a></td>
</tr>
@empty
<tr>
    <td colspan="2">no record found</td>
</tr>
@endforelse