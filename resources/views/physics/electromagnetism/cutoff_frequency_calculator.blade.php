<x-calc.page
    title="Cutoff Frequency Calculator - SolveKit"
    description="Free cutoff frequency calculator: −3 dB frequency of RC and RL filters, and LC resonance."
    lede="Find a filter’s cutoff frequency."
    about="An RC or RL filter passes signals on one side of its cutoff and attenuates the other. At f_c the output is 3 dB down."
    :calc="['engine' => 'ph-em', 'tool' => 'cutoff', 'fields' => ['kind', 'R', 'C', 'L', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'C' => collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf'])->all(), 'L' => collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh'])->all()], 'data' => ['units' => collect(config('units'))->only(['capacitance', 'energy', 'force', 'frequency_hz', 'inductance', 'length', 'mass', 'resistance', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is f_c for 1 kΩ and 100 nF?', 'answer' => '1,591.55 Hz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="kind" label="Circuit" :options="['rc' => 'RC', 'rl' => 'RL', 'lc' => 'LC (resonance)']" selected="rc" />
        <div data-show-when="kind:rc,rl">
            <x-calc.field name="R" label="Resistance" value="1" min="0" placeholder="Resistance">
                <label for="calc-R-unit" class="sr-only">Resistance unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:rc,lc">
            <x-calc.field name="C" label="Capacitance" value="100" min="0" placeholder="Capacitance">
                <label for="calc-C-unit" class="sr-only">Capacitance unit</label>
                <select id="calc-C-unit" name="C-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.capacitance'))->only(['f', 'mf', 'uf', 'nf', 'pf']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nf')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="kind:rl,lc">
            <x-calc.field name="L" label="Inductance" value="10" min="0" placeholder="Inductance">
                <label for="calc-L-unit" class="sr-only">Inductance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.inductance'))->only(['h', 'mh', 'uh', 'nh']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mh')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
    </div>

    <x-calc.result label="Cutoff frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'hz', 'kind' => 'rc', 'R' => 1, 'R-unit' => 'kohm', 'C' => 100, 'C-unit' => 'nf', 'L' => 10, 'L-unit' => 'mh'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="First-order low-pass response" name="bode" />
        <x-calc.rows heading="Details" :rows="[
            'tau' => ['label' => 'Time constant'],
            'w' => ['label' => 'Angular frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
