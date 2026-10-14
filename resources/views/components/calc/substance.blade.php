@props([
    'groups',
    'selected',
    'densityLabel' => 'g/mL',
    'scale' => 1,
    'label' => 'Substance',
])

{{-- groups: [key => ['label' => …, 'items' => [key => ['name' => …, 'density' => g/mL]]]] --}}
@php
    $densities = collect($groups)->flatMap(fn ($group) => $group['items']);
    $density = isset($densities[$selected]) ? round($densities[$selected]['density'] * $scale, 6) : null;
@endphp

<div class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
    <div class="flex min-w-0 flex-col gap-1.5">
        <label for="calc-substance" class="text-[13px] font-semibold text-slate-700">{{ $label }}</label>
        <select id="calc-substance" name="substance" class="h-12 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 text-[15px] text-slate-900 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
            @foreach($groups as $group)
                <optgroup label="{{ $group['label'] }}">
                    @foreach($group['items'] as $key => $item)
                        <option value="{{ $key }}" @selected($key === $selected)>{{ $item['name'] }}</option>
                    @endforeach
                </optgroup>
            @endforeach
            <option value="custom">Custom density</option>
        </select>
    </div>
    <x-calc.field name="density" label="Density" :value="$density" min="0" :suffix="$densityLabel" help="Typical value; edit it for your material." />
</div>
