<x-calc.page
    title="Resistor Noise Calculator - SolveKit"
    description="Free resistor noise calculator: thermal (Johnson–Nyquist) noise voltage and density."
    lede="Find resistor thermal noise."
    about="Every resistor generates noise from the thermal motion of its electrons: √(4kTRB). A 1 kΩ resistor makes about 4 nV/√Hz at room temperature."
    :calc="['engine' => 'ph-elec', 'tool' => 'resistor_noise', 'fields' => ['R', 'T', 'B', 'out'], 'unitFields' => ['R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all(), 'B' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'frequency_hz', 'length', 'mass', 'resistance', 'speed', 'temperature', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What noise does 10 kΩ make over 20 kHz?', 'answer' => '1.8147 µV.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="R" label="Resistance" value="10" min="0" placeholder="Resistance">
            <label for="calc-R-unit" class="sr-only">Resistance unit</label>
            <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kohm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="T" label="Temperature" value="25" placeholder="Temperature">
            <label for="calc-T-unit" class="sr-only">Temperature unit</label>
            <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'c')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="B" label="Bandwidth" value="20" min="0" placeholder="Bandwidth">
            <label for="calc-B-unit" class="sr-only">Bandwidth unit</label>
            <select id="calc-B-unit" name="B-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'khz')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="out" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="uv" />
    </div>

    <x-calc.result label="Thermal noise voltage (RMS)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['out' => 'uv', 'R' => 10, 'R-unit' => 'kohm', 'T' => 25, 'T-unit' => 'c', 'B' => 20, 'B-unit' => 'khz'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'density' => ['label' => 'Noise density'],
            'I' => ['label' => 'Noise current'],
            'dbv' => ['label' => 'In dBV'],
            'P' => ['label' => 'Available noise power'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
