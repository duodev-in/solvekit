<x-calc.page
    title="Root Mean Square Velocity Calculator - SolveKit"
    description="Free RMS velocity calculator: v_rms = √(3RT/M), solved for any value."
    lede="Solve v_rms = √(3RT ÷ M)."
    about="The root-mean-square speed sets the average kinetic energy of gas molecules: ½mv_rms² = 3/2 kT."
    :calc="['engine' => 'ph-thermo', 'tool' => 'rms_velocity', 'fields' => ['solve', 'v', 'T', 'M', 'out_v', 'out_T'], 'unitFields' => ['v' => collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'temperature', 'v'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is v_rms of N₂ at 298 K?', 'answer' => '515.366 m/s.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['v' => 'RMS speed', 'T' => 'Temperature', 'M' => 'Molar mass (g/mol)']" selected="v" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:T,M" hidden>
            <x-calc.field name="v" label="RMS speed" value="515.24" placeholder="RMS speed">
                <label for="calc-v-unit" class="sr-only">RMS speed unit</label>
                <select id="calc-v-unit" name="v-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.speed'))->only(['ms', 'cms', 'kmh', 'mph', 'fts', 'knot', 'kms', 'c']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ms')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,M">
            <x-calc.field name="T" label="Temperature" value="298.15" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:v,T">
            <x-calc.field name="M" label="Molar mass (g/mol)" value="28" step="any" />
        </div>
        <div data-show-when="solve:v">
            <x-calc.select name="out_v" label="Show the result in" :options="['ms' => 'm/s', 'cms' => 'cm/s', 'kmh' => 'km/h', 'mph' => 'mph', 'fts' => 'ft/s', 'knot' => 'kn', 'kms' => 'km/s', 'c' => 'c']" selected="ms" />
        </div>
        <div data-show-when="solve:T" hidden>
            <x-calc.select name="out_T" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="k" />
        </div>
    </div>

    <x-calc.result label="RMS speed" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'v', 'v' => 515.24, 'v-unit' => 'ms', 'out_v' => 'ms', 'T' => 298.15, 'T-unit' => 'k', 'out_T' => 'k', 'M' => 28],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'ke' => ['label' => 'Mean kinetic energy per molecule'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>v_rms = √(3RT ÷ M)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
