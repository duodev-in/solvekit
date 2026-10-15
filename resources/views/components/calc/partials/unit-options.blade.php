@foreach($options as $key => $option)
    @if(is_array($option))
        <optgroup label="{{ $key }}">
            @foreach($option as $groupKey => $groupLabel)
                <option value="{{ $groupKey }}" @selected((string) $groupKey === (string) $selected)>{{ $groupLabel }}</option>
            @endforeach
        </optgroup>
    @else
        <option value="{{ $key }}" @selected((string) $key === (string) $selected)>{{ $option }}</option>
    @endif
@endforeach
