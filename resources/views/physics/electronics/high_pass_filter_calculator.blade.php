<x-calc.page
    title="High Pass Filter Calculator - SolveKit"
    description="Free high pass filter calculator: cutoff frequency and response of RC and RL high-pass filters."
    lede="Design a high-pass filter."
    about="A high-pass filter blocks low frequencies and passes high ones. Its −3 dB point is 1/2πRC (or R/2πL), with a 20 dB per decade slope per stage."
    :calc="['engine' => 'ph-elec', 'tool' => 'high_pass', 'fields' => ['type', 'R', 'C', 'L', 'order', 'f', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all(), 'f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is f_c for 1.6 kΩ and 100 nF?', 'answer' => '994.718 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="type" label="Filter" :options="['rc' => 'RC', 'rl' => 'RL']" selected="rc" />
        <x-calc.field name="R" label="Resistance" value="1.6" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <div data-show-when="type:rc">
            <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="type:rl">
            <x-calc.field name="L" label="Inductance" value="10" min="0" placeholder="Inductance">
                <label for="calc-L-unit" class="sr-only">Inductance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="order" label="Order (identical buffered stages)" :options="['1' => 'First order', '2' => 'Second order (two stages)', '3' => 'Third order (three stages)']" selected="1" />
        <x-calc.field name="f" label="Test frequency (optional)" value="5" min="0" placeholder="Test frequency (optional)">
            <label for="calc-f-unit" class="sr-only">Test frequency (optional) unit</label>
            <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Cutoff frequency (−3 dB, one stage)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'type' => 'rc', 'R' => 1.6, 'R-unit' => 'kohm', 'C' => 100, 'C-unit' => 'nf', 'L' => 10, 'L-unit' => 'mh', 'order' => '1', 'f' => 5, 'f-unit' => 'khz'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Magnitude response" name="bode" />
        <x-calc.rows heading="Details" :rows="[
            'gain' => ['label' => 'Gain at the test frequency'],
            'phase' => ['label' => 'Phase at the test frequency'],
            'slope' => ['label' => 'Roll-off'],
            'overall' => ['label' => 'Overall −3 dB point'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
