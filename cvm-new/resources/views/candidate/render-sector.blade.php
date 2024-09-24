@foreach ($data as $sector)
    <div class="rp_item">
        <div class="switch_button">
            <label class="switch">
                <input type="radio" name="sector_id" class="sector-data-data"
                value="{{ $sector->id }}" onclick="sector({{$sector->id}})"/>
                <span class="slider"></span>
            </label>
            <div>{{ ucfirst($sector->name)}}</div>
        </div>
    </div>
@endforeach