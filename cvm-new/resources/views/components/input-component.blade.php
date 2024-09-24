<div class="add__option">
    <div class="input_grp">
    <label for="{{$name}}">{{$title}} <span class="text-danger">@if ($title) * @endif</span></label>
   <input type="{{$type ?? 'text'}}" class="form-control" name="{{$name}}" placeholder="{{$placeholder}}" id="{{$id}}" @isset($value) value="{{$value}}" @endisset>
   {!! $slot !!}
</div>

</div>