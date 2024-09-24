<div class="add__option">
    <div class="input_grp">
    <label for="">{{$title}} <span class="text-danger">*</span></label>
    <select name="{{ $name }}" class="form-control" id="job_category_id">
        @foreach ($options as $value => $label)
        @if($value == 0)
            <option value="" @if ($selected == $value) selected @endif>Select Category</option>
            <option value="{{ $label->id }}">{{ $label->name }}</option>
       @else
            <option value="{{ $label->id }}" @if ($selected == $value) selected @endif>{{ $label->name }}</option>
        @endif
        @endforeach
    </select>
    {!! $slot !!}
    </div>
</div>