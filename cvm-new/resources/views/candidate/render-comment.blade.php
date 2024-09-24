@forelse($comments as $k => $comment)
<tr>
<td>{{ $k+1 }}</td>
<td>{{isset($comment->contact_through) ? $comment->contact_through : '__'}}</td>
<td>{{$comment->comment}}</td>
<td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteCandiateComment({{$comment->id}})" >Delete</a></td>
</tr>
@empty
<tr>
    <td colspan="3">no record found</td>
</tr>
@endforelse