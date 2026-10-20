<x-calc.page
    title="Acceleration Calculator - SolveKit"
    description="Free acceleration calculator: acceleration from the change in velocity and time, or solve for either."
    lede="Solve a = Δv ÷ t."
    about="Acceleration is how fast velocity changes. A car going 0–100 km/h in 10 s averages 2.78 m/s², about 0.28 g."
    :calc="['engine' => 'ph-mech', 'tool' => 'acceleration', 'fields' => ['solve', 'a', 'dv', 't', 'out_a', 'out_dv', 'out_t'], 'unitFields' => ['a' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all(), 'dv' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['a', 'acceleration', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the acceleration for 0–100 km/h in 10 s?', 'answer' => '2.77778 m/s².'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['a' => 'Acceleration', 'dv' => 'Change in velocity', 't' => 'Time']" selected="a" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:dv,t" hidden>
            <x-calc.field name="a" label="Acceleration" value="2.7778" placeholder="Acceleration">
                <label for="calc-a-unit" class="sr-only">Acceleration unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a,t">
            <x-calc.field name="dv" label="Change in velocity" value="100" placeholder="Change in velocity">
                <label for="calc-dv-unit" class="sr-only">Change in velocity unit</label>
                <select id="calc-dv-unit" name="dv-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kmh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a,dv">
            <x-calc.field name="t" label="Time" value="10" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:a">
            <x-calc.select name="out_a" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
        </div>
        <div data-show-when="solve:dv" hidden>
            <x-calc.select name="out_dv" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="kmh" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
    </div>

    <x-calc.result label="Acceleration" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'a', 'a' => 2.7778, 'a-unit' => 'ms2', 'out_a' => 'ms2', 'dv' => 100, 'dv-unit' => 'kmh', 'out_dv' => 'kmh', 't' => 10, 't-unit' => 's', 'out_t' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'g' => ['label' => 'In g'],
            'dist' => ['label' => 'Distance covered from rest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a = Δv ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
