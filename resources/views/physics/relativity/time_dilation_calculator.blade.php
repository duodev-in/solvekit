<x-calc.page
    title="Time Dilation Calculator - SolveKit"
    description="Free time dilation calculator: Δt = γΔt₀ for moving clocks, solved for any value."
    lede="Solve Δt = γΔt₀."
    about="A clock moving at speed v ticks slower by the Lorentz factor γ. At 0.9c one year on board is 2.29 years at home."
    :calc="['engine' => 'ph-astro', 'tool' => 'time_dilation', 'fields' => ['solve', 't', 't0', 'v', 'out_t', 'out_t0', 'out_v'], 'unitFields' => ['t' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 't0' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'How long is one ship year at 0.9c?', 'answer' => '2.29416 yr on Earth.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['t' => 'Dilated time (seen by the observer)', 't0' => 'Proper time (on the moving clock)', 'v' => 'Speed']" selected="t" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:t0,v" hidden>
            <x-calc.field name="t" label="Dilated time (seen by the observer)" value="2.29416" placeholder="Dilated time (seen by the observer)">
                <label for="calc-t-unit" class="sr-only">Dilated time (seen by the observer) unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'year')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:t,v">
            <x-calc.field name="t0" label="Proper time (on the moving clock)" value="1" placeholder="Proper time (on the moving clock)">
                <label for="calc-t0-unit" class="sr-only">Proper time (on the moving clock) unit</label>
                <select id="calc-t0-unit" name="t0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'year')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:t,t0">
            <x-calc.field name="v" label="Speed" value="0.9" placeholder="Speed">
                <label for="calc-v-unit" class="sr-only">Speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:t">
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="year" />
        </div>
        <div data-show-when="solve:t0" hidden>
            <x-calc.select name="out_t0" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="year" />
        </div>
        <div data-show-when="solve:v" hidden>
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="c" />
        </div>
    </div>

    <x-calc.result label="Dilated time (seen by the observer)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 't', 't' => 2.29416, 't-unit' => 'year', 'out_t' => 'year', 't0' => 1, 't0-unit' => 'year', 'out_t0' => 'year', 'v' => 0.9, 'v-unit' => 'c', 'out_v' => 'c'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'gamma' => ['label' => 'Lorentz factor γ'],
            'diff' => ['label' => 'Difference'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Δt = γ Δt₀</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
