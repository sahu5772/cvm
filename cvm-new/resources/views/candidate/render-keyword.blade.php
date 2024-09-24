@foreach ($data as $keyword)
    <div class="rp_item">
        <div class="switch_button">
            <label class="switch">
                <input type="checkbox" name="keyword" value="{{ $keyword->id }}"
                 onclick="keyword({{$keyword->id}})"/>
                <span class="slider"></span>
            </label>
            <div>{{ ucfirst($keyword->keyword)}}</div>
        </div>
    </div>
@endforeach