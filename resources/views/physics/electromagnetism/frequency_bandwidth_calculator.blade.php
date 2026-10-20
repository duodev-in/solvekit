<x-calc.page
    title="Frequency Bandwidth Calculator - SolveKit"
    description="Free bandwidth calculator: bandwidth, centre frequency and Q from band edges or from Q."
    lede="Find bandwidth and Q."
    about="Bandwidth is the width of a band between its −3 dB edges. Q is the centre frequency divided by the bandwidth."
    :calc="['engine' => 'ph-em', 'tool' => 'bandwidth', 'fields' => ['mode', 'f1', 'f2', 'f0', 'Q', 'out'], 'unitFields' => ['f1' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'f2' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'f0' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the bandwidth of 88–108 MHz?', 'answer' => '20 MHz.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="I know" :options="['edges' => 'Lower and upper frequencies', 'q' => 'Centre frequency and Q']" selected="edges" />
        <div data-show-when="mode:edges">
            <x-calc.field name="f1" label="Lower frequency" value="88" min="0" placeholder="Lower frequency">
                <label for="calc-f1-unit" class="sr-only">Lower frequency unit</label>
                <select id="calc-f1-unit" name="f1-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:edges">
            <x-calc.field name="f2" label="Upper frequency" value="108" min="0" placeholder="Upper frequency">
                <label for="calc-f2-unit" class="sr-only">Upper frequency unit</label>
                <select id="calc-f2-unit" name="f2-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:q">
            <x-calc.field name="f0" label="Centre frequency" value="10.7" min="0" placeholder="Centre frequency">
                <label for="calc-f0-unit" class="sr-only">Centre frequency unit</label>
                <select id="calc-f0-unit" name="f0-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mhz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="mode:q">
            <x-calc.field name="Q" label="Quality factor Q" value="50" min="0" step="any" />
        </div>
        <x-calc.select name="out" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="mhz" />
    </div>

    <x-calc.result label="Bandwidth" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'mhz', 'mode' => 'edges', 'f1' => 88, 'f1-unit' => 'mhz', 'f2' => 108, 'f2-unit' => 'mhz', 'f0' => 10.7, 'f0-unit' => 'mhz', 'Q' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'centre' => ['label' => 'Centre frequency (geometric)'],
            'frac' => ['label' => 'Fractional bandwidth'],
            'Q' => ['label' => 'Q factor'],
            'octaves' => ['label' => 'Width in octaves'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
