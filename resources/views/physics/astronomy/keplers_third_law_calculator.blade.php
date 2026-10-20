<x-calc.page
    title="Kepler's Third Law Calculator - SolveKit"
    description="Free Kepler's third law calculator: orbital period, semi-major axis or central mass from T² = 4π²a³/G(M + m)."
    lede="Solve Kepler's third law."
    about="The square of the orbital period is proportional to the cube of the orbit size. With Newton’s gravity the constant depends on the total mass, which is how astronomers weigh stars and planets."
    :calc="['engine' => 'ph-astro', 'tool' => 'kepler3', 'fields' => ['solve', 'T', 'a', 'M', 'm', 'out_T', 'out_a', 'out_M', 'out_m'], 'unitFields' => ['T' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all(), 'a' => collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi'])->all(), 'M' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all(), 'm' => collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun'])->all()], 'data' => ['units' => collect(config('units'))->only(['astro_mass', 'astronomical', 'energy', 'force', 'length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is Earth’s orbital period?', 'answer' => '365.256 d.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['T' => 'Orbital period', 'a' => 'Semi-major axis', 'M' => 'Central mass', 'm' => 'Orbiting mass (optional)']" selected="T" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:a,M,m" hidden>
            <x-calc.field name="T" label="Orbital period" value="365.256" placeholder="Orbital period">
                <label for="calc-T-unit" class="sr-only">Orbital period unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'day')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,M,m">
            <x-calc.field name="a" label="Semi-major axis" value="1" min="0" placeholder="Semi-major axis">
                <label for="calc-a-unit" class="sr-only">Semi-major axis unit</label>
                <select id="calc-a-unit" name="a-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astronomical'))->only(['m', 'km', 'au', 'ly', 'pc', 'mpc', 'mi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'au')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,a,m">
            <x-calc.field name="M" label="Central mass" value="1" min="0" placeholder="Central mass">
                <label for="calc-M-unit" class="sr-only">Central mass unit</label>
                <select id="calc-M-unit" name="M-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'msun')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T,a,M">
            <x-calc.field name="m" label="Orbiting mass (optional)" value="1" min="0" placeholder="Orbiting mass (optional)">
                <label for="calc-m-unit" class="sr-only">Orbiting mass (optional) unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.astro_mass'))->only(['kg', 't', 'mmoon', 'mearth', 'mjup', 'msun']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mearth')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:T">
            <x-calc.select name="out_T" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="day" />
        </div>
        <div data-show-when="solve:a" hidden>
            <x-calc.select name="out_a" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'au' => 'AU', 'ly' => 'ly', 'pc' => 'pc', 'mpc' => 'Mpc', 'mi' => 'mi']" selected="au" />
        </div>
        <div data-show-when="solve:M" hidden>
            <x-calc.select name="out_M" label="Show the result in" :options="['kg' => 'kg', 't' => 't', 'mmoon' => 'M☾', 'mearth' => 'M⊕', 'mjup' => 'M♃', 'msun' => 'M☉']" selected="msun" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 't' => 't', 'mmoon' => 'M☾', 'mearth' => 'M⊕', 'mjup' => 'M♃', 'msun' => 'M☉']" selected="mearth" />
        </div>
    </div>

    <x-calc.result label="Orbital period" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'T', 'T' => 365.256, 'T-unit' => 'day', 'out_T' => 'day', 'a' => 1, 'a-unit' => 'au', 'out_a' => 'au', 'M' => 1, 'M-unit' => 'msun', 'out_M' => 'msun', 'm' => 1, 'm-unit' => 'mearth', 'out_m' => 'mearth'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'years' => ['label' => 'Period in years'],
            'v' => ['label' => 'Mean orbital speed'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>T² = 4π² a³ ÷ G(M + m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
