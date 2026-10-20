<x-calc.page
    title="RLC Impedance Calculator - SolveKit"
    description="Free RLC impedance calculator: impedance magnitude and phase of series or parallel R, L and C."
    lede="Find RLC impedance."
    about="Impedance combines resistance with the reactances of L and C: Z = R + j(X_L − X_C) in series."
    :calc="['engine' => 'ph-elec', 'tool' => 'rlc_impedance', 'fields' => ['kind', 'R', 'L', 'C', 'f', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is |Z| at 1 kHz for the example?', 'answer' => '68.5649 Ω.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Connection" :options="['series' => 'Series', 'parallel' => 'Parallel']" selected="series" />
        <x-calc.field name="R" label="Resistance" value="50" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Inductance (0 if none)" value="10" min="0" placeholder="Inductance (0 if none)">
            <label for="calc-L-unit" class="sr-only">Inductance (0 if none) unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="C" label="Capacitance (0 if none)" value="10" min="0" placeholder="Capacitance (0 if none)">
            <label for="calc-C-unit" class="sr-only">Capacitance (0 if none) unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="f" label="Frequency" value="1000" min="0" placeholder="Frequency">
            <label for="calc-f-unit" class="sr-only">Frequency unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['ohm' => 'Ω', 'mohm' => 'mΩ', 'kohm' => 'kΩ', 'megohm' => 'MΩ', 'gohm' => 'GΩ']" selected="ohm" />
    </div>

    <x-calc.result label="Impedance magnitude" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'ohm', 'kind' => 'series', 'R' => 50, 'R-unit' => 'ohm', 'L' => 10, 'L-unit' => 'mh', 'C' => 10, 'C-unit' => 'uf', 'f' => 1000, 'f-unit' => 'hz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'phase' => ['label' => 'Phase angle'],
            'rect' => ['label' => 'Rectangular form'],
            'XL' => ['label' => 'Inductive reactance'],
            'XC' => ['label' => 'Capacitive reactance'],
            'behaves' => ['label' => 'Behaves as'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
