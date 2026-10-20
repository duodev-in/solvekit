<x-calc.page
    title="RLC Circuit Calculator - SolveKit"
    description="Free RLC circuit calculator: resonant frequency, Q, bandwidth and damping of series and parallel RLC circuits."
    lede="Analyse an RLC circuit."
    about="An RLC circuit resonates at 1/2π√(LC); its Q sets how sharp the resonance is and whether its step response rings."
    :calc="['engine' => 'ph-elec', 'tool' => 'rlc_circuit', 'fields' => ['kind', 'R', 'L', 'C', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is f₀ of 10 Ω, 10 mH and 1 µF?', 'answer' => '1,591.55 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Connection" :options="['series' => 'Series RLC', 'parallel' => 'Parallel RLC']" selected="series" />
        <x-calc.field name="R" label="Resistance" value="10" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="L" label="Inductance" value="10" min="0" placeholder="Inductance">
            <label for="calc-L-unit" class="sr-only">Inductance unit</label>
            <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="C" label="Capacitance" value="1" min="0" placeholder="Capacitance">
            <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
            <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'uf')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Resonant frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'kind' => 'series', 'R' => 10, 'R-unit' => 'ohm', 'L' => 10, 'L-unit' => 'mh', 'C' => 1, 'C-unit' => 'uf'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'Q' => ['label' => 'Quality factor Q'],
            'bw' => ['label' => 'Bandwidth'],
            'zeta' => ['label' => 'Damping ratio ζ'],
            'type' => ['label' => 'Step response'],
            'fd' => ['label' => 'Damped ringing frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
