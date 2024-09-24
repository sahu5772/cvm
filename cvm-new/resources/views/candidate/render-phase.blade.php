@foreach ($data as $phase)
    <div class="rp_item">
        <div class="switch_button">
            <label class="switch">
                <input type="radio" name="phase_id" class="phase-data-id"
                value="{{ $phase->id }}" onclick="phaseData({{$phase->id}})"/>
                <span class="slider"></span>
            </label>
            <div>{{ ucfirst($phase->name)}}</div>
        </div>
    </div>
@endforeach