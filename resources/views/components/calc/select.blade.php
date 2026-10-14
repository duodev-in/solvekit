@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
])

{{-- options: [value => label] or [group label => [value => label]] for optgroups. --}}
<div class="flex min-w-0 flex-col gap-1.5">
    <label for="calc-{{ $name }}" class="text-[13px] font-semibold text-slate-700">{{ $label }}</label>
    <select
        id="calc-{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->class(['h-12 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 text-[15px] text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30']) }}
    >
        @foreach($options as $value => $option)
            @if(is_array($option))
                <optgroup label="{{ $value }}">
                    @foreach($option as $groupValue => $groupLabel)
                        <option value="{{ $groupValue }}" @selected((string) $groupValue === (string) $selected)>{{ $groupLabel }}</option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $value }}" @selected((string) $value === (string) $selected)>{{ $option }}</option>
            @endif
        @endforeach
    </select>
</div>
