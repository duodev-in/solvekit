<x-calc.page
    title="Newton's Law of Cooling Calculator - SolveKit"
    description="Free Newton's law of cooling calculator: temperature over time, or the cooling constant from two readings."
    lede="Model cooling over time."
    about="A body cools at a rate proportional to its temperature difference from the surroundings, so the difference decays exponentially."
    :calc="['engine' => 'ph-thermo', 'tool' => 'newton_cooling', 'fields' => ['mode', 'T0', 'Ta', 'k', 't1', 'T1', 't', 'out'], 'unitFields' => ['T0' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'Ta' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 't1' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'T1' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the temperature after 30 minutes in the example?', 'answer' => '33.0612 °C.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['k' => 'The cooling constant', 'two' => 'A second reading (finds k)']" selected="two" />
        <x-calc.field name="T0" label="Starting temperature" value="90" placeholder="Starting temperature">
            <label for="calc-T0-unit" class="sr-only">Starting temperature unit</label>
            <select id="calc-T0-unit" name="T0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="Ta" label="Surroundings" value="20" placeholder="Surroundings">
            <label for="calc-Ta-unit" class="sr-only">Surroundings unit</label>
            <select id="calc-Ta-unit" name="Ta-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="mode:k">
            <x-calc.field name="k" label="Cooling constant (per minute)" value="0.05" min="0" step="any" />
        </div>
        <div data-show-when="mode:two">
            <x-calc.field name="t1" label="Time of the second reading" value="10" placeholder="Time of the second reading">
                <label for="calc-t1-unit" class="sr-only">Time of the second reading unit</label>
                <select id="calc-t1-unit" name="t1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:two">
            <x-calc.field name="T1" label="Second reading" value="60" placeholder="Second reading">
                <label for="calc-T1-unit" class="sr-only">Second reading unit</label>
                <select id="calc-T1-unit" name="T1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.field name="t" label="Time to evaluate" value="30" placeholder="Time to evaluate">
            <label for="calc-t-unit" class="sr-only">Time to evaluate unit</label>
            <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'min')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="c" />
    </div>

    <x-calc.result label="Temperature at that time" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'c', 'mode' => 'two', 'T0' => 90, 'T0-unit' => 'c', 'Ta' => 20, 'Ta-unit' => 'c', 'k' => 0.05, 't1' => 10, 't1-unit' => 'min', 'T1' => 60, 'T1-unit' => 'c', 't' => 30, 't-unit' => 'min'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Cooling curve" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'k' => ['label' => 'Cooling constant'],
            'half' => ['label' => 'Time to halve the difference'],
            'to40' => ['label' => 'Time to reach 40 °C'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
